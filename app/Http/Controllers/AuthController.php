<?php

namespace App\Http\Controllers;

use App\Libraries\RandomObjectGeneration;
use App\Models\Two_Factor;
use App\Models\User;
use App\Models\User_Permissions;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * create
     * Create a new user instance after a valid registration.
     *
     * @param   Request         $request
     * @return  User
     */
    public static function create(Request $request) {
        $users = User::all();
        $username = $request->input('usernameText');
        foreach($users as $user) {
            if($user->Username == $username) {
                return redirect()->route('register');
            }
        }
        if($request->input('emailText') != $request->input('confirmEmailText')) {
            return redirect()->route('register');
        }
        $email = $request->input('emailText');
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';
        $password = RandomObjectGeneration::random_str(getenv('DEFAULT_LENGTH_PASSWORDS'),$keyspace);
        $user = User::create([
            'Username' => $username,
            'Email' => $email,
            'FirstName' => $request->input('firstNameText'),
            'LastName' => $request->input('lastNameText'),
            'MiddleInitial' => $request->input('initialText'),
            'Password' => password_hash($password,PASSWORD_DEFAULT),
            '2FA' => 0,
        ]);
        EmailController::sendNewAccountEmail($user,$password);
        return redirect()->route('users');
    }

    /**
     * authenticate
     * Authenticates the user against the user's database object. Submits to 2FA if they have
     * the option enabled, otherwise logs the user in.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
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

                EmailController::sendTwoFactorEmail($user,$code);
                \Session::put('2faUser',$user);
                return redirect()->route('2fa');
            }
            \Session::put('authUser',$user);
            \Session::put('authIp',$_SERVER['REMOTE_ADDR']);
            if($user->UserType == 1) {
                \Session::put('adminUser',$user);
            }
            $intended = \Session::get('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');
        }
        return redirect()->route('login');
    }

    /**
     * generateTwoFactorPage
     * Route for generating the 2FA page.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateTwoFactorPage() {
        if(\Session::has('2faUser')) {
            return view('auth.2fa');
        }
        return redirect()->to('login');
    }

    /**
     * twoFactorVerify
     * Validates the 2FA code to authenticate the user.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function twoFactorVerify(Request $request) {
        if(\Session::has('2faUser')) {
            $user = \Session::get('2faUser');
            $twoFactor = Two_Factor::where([
                'UserId' => $user->Id, 'Ip' => $_SERVER['REMOTE_ADDR']
            ])->first();
            if(password_verify($request->input('codeText'),$twoFactor->Code)) {
                \Session::put('authUser',$user);
                \Session::put('authIp',$_SERVER['REMOTE_ADDR']);
                if($user->UserType == 1) {
                    \Session::put('adminUser',$user);
                }
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
        return redirect()->route('login');
    }

    /**
     * resend2FA
     * Generates and sends a new 2FA code.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
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

        EmailController::sendTwoFactorEmail($user,$code);
        return redirect()->route('2fa');
    }

    /**
     * check
     * Validates if the user is authenticated on this IP Address.
     *
     * @return  bool
     */
    public static function check() {
        return \Session::get('authUser') && \Session::get('authIp') == $_SERVER['REMOTE_ADDR'];
    }

    public static function adminCheck() {
        return \Session::has('adminUser');
    }

    /**
     * logout
     * Removes session variables storing the authenticated account.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function logout() {
        \Session::forget('authUser');
        \Session::forget('authIp');
        \Session::forget('adminUser');
        \Session::forget('intended');
        return redirect()->route('login');
    }

    public static function generateLogin() {
        if(self::check()) {
            return redirect()->route('authHome');
        }
        return view('auth.login');
    }

    public static function generateRegister() {
        if(self::adminCheck()) {
            $permissions = User_Permissions::all();
            $variables = array('permissions'=>$permissions);
            return view('auth.register')->with($variables);
        }
        return redirect()->route('e401');
    }
}
