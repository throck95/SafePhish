<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        ]);
        self::authenticate($request);
    }

    public static function authenticate(Request $request) {
        $user = User::where('Username',$request->input('usernameText'))->first();
        if(password_verify($request->input('passwordText'),$user->Password)) {
            \Session::put('authUser',$user);
            \Session::put('authIp',$_SERVER['REMOTE_ADDR']);
            $intended = \Session::get('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');
        }
        return redirect()->route('login');
    }

    public static function check() {
        return \Session::get('authUser') && \Session::get('authIp') == $_SERVER['REMOTE_ADDR'];
    }

    public static function logout() {
        \Session::forget('authUser');
        \Session::forget('authIp');
        \Session::forget('intended');
        return view('auth.logout'); //create this view
    }
}
