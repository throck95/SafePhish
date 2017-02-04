<?php

namespace App\Http\Controllers;

use App\Libraries\RandomObjectGeneration;
use App\Models\Two_Factor;
use Illuminate\Http\Request;
use App\Models\User;
use App\Email;

class AuthController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param   Request         $request
     * @return  User
     */
    public static function create(Request $request) {
        User::create([
            'Username' => $request->input('usernameText'),
            'Email' => $request->input('emailText'),
            'FirstName' => $request->input('firstNameText'),
            'LastName' => $request->input('lastNameText'),
            'MiddleInitial' => $request->input('initialText'),
            'Password' => password_hash($request->input('passwordText'),PASSWORD_DEFAULT),
            '2FA' => 0,
        ]);
        self::authenticate($request);
    }

    public static function authenticate(Request $request) {
        $user = User::where('Username',$request->input('usernameText'))->first();
        if(password_verify($request->input('passwordText'),$user->Password)) {
            if($user->getAttribute('2FA') == 1) {
                $twoFactor = Two_Factor::where([
                    'UserId' => $user->Id, 'Ip' => $_SERVER['REMOTE_ADDR']
                ])->first();
                if(count($twoFactor)) {
                    $twoFactor->delete();
                }
                $code = RandomObjectGeneration::random_str(6, '1234567890');
                Two_Factor::create([
                    'UserID' => $user->Id,
                    'Ip' => $_SERVER['REMOTE_ADDR'],
                    'Code' => password_hash($code,PASSWORD_DEFAULT)
                ]);

                Email::executeTwoFactorEmail($user,$code);
                \Session::put('2faUser',$user);
                return redirect()->route('2fa');
            }
            else {
                \Session::put('authUser',$user);
                \Session::put('authIp',$_SERVER['REMOTE_ADDR']);
                $intended = \Session::get('intended');
                if($intended) {
                    return redirect()->to($intended);
                }
                return redirect()->route('authHome');
            }
        }
        return redirect()->route('login');
    }

    public static function resend2FA() {
        $user = \Session::get('2faUser');
        $twoFactor = Two_Factor::where([
            'UserId' => $user->Id, 'Ip' => $_SERVER['REMOTE_ADDR']
        ])->first();
        if(count($twoFactor)) {
            $twoFactor->delete();
        }
        $code = RandomObjectGeneration::random_str(6, '1234567890');
        Two_Factor::create([
            'UserID' => $user->Id,
            'Ip' => $_SERVER['REMOTE_ADDR'],
            'Code' => password_hash($code,PASSWORD_DEFAULT)
        ]);

        Email::executeTwoFactorEmail($user,$code);
        return redirect()->route('2fa');
    }

    public static function twoFactorVerify(Request $request) {
        $user = \Session::get('2faUser');
        $twoFactor = Two_Factor::where([
            'UserId' => $user->Id, 'Ip' => $_SERVER['REMOTE_ADDR']
        ])->first();
        if(password_verify($request->input('codeText'),$twoFactor->Code)) {
            \Session::put('authUser',$user);
            \Session::put('authIp',$_SERVER['REMOTE_ADDR']);
            \Session::forget('2faUser');
            $twoFactor->delete();
            $intended = \Session::get('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');
        }
        return redirect()->route('2fa');
    }

    public static function check() {
        return \Session::get('authUser') && \Session::get('authIp') == $_SERVER['REMOTE_ADDR'];
    }

    public static function logout() {
        \Session::forget('authUser');
        \Session::forget('authIp');
        \Session::forget('intended');
        return redirect()->route('login');
    }
}
