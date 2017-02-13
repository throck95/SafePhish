<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Libraries\ErrorLogging;
use App\Libraries\RandomObjectGeneration;
use App\Models\Sessions;
use App\Models\Two_Factor;
use App\Models\User;
use App\Models\User_Permissions;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

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
        try {
            if($request->input('emailText') != $request->input('confirmEmailText')) {
                return redirect()->route('register');
            }

            $email = $request->input('emailText');
            $username = $request->input('usernameText');
            $password = RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_PASSWORDS')),true);

            $user = User::create([
                'Username' => $username,
                'Email' => $email,
                'FirstName' => $request->input('firstNameText'),
                'LastName' => $request->input('lastNameText'),
                'MiddleInitial' => $request->input('middleInitialText'),
                'Password' => password_hash($password,PASSWORD_DEFAULT),
                '2FA' => 0,
            ]);

            EmailController::sendNewAccountEmail($user,$password);
            return redirect()->route('users');

        } catch(QueryException $qe) {
            if(strpos($qe->getMessage(),"1062 Duplicate entry 'admin'") !== false) {
                return redirect()->route('register'); //return with username exists error
            }
            return redirect()->route('register'); //return with unknown error

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
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
        try {
            $user = User::where('Username',$request->input('usernameText'))->first();
            $password = $request->input('passwordText');
            if(empty($user) || !password_verify($password,$user->Password)) {
                return redirect()->route('login');
            }

            User::updateUser($user,$user->Email,password_hash($password,PASSWORD_DEFAULT),$user->getAttribute('2FA'));

            $session = Sessions::where('UserId',$user->Id)->first();
            if(!empty($session)) {
                $session->delete();
            }

            $ip = $_SERVER['REMOTE_ADDR'];
            $cryptor = new Cryptor();

            if($user->getAttribute('2FA') === 1) {
                $twoFactor = Two_Factor::where([
                    'UserId' => $user->Id, 'Ip' => $ip
                ])->first();
                if(!empty($twoFactor)) {
                    $twoFactor->delete();
                }

                $code = RandomObjectGeneration::random_str(6,false,'1234567890');
                $twoFactor = Two_Factor::create([
                    'UserId' => $user->Id,
                    'Ip' => $_SERVER['REMOTE_ADDR'],
                    'Code' => password_hash($code,PASSWORD_DEFAULT)
                ]);

                EmailController::sendTwoFactorEmail($user,$code);

                $newSession = Sessions::create([
                    'UserId' => $user->Id,
                    'Ip' => $ip,
                    'TwoFactorId' => $twoFactor->Id,
                    'Authenticated' => 0
                ]);

                $encryptedSession = $cryptor->encrypt($newSession->Id);
                \Session::put('sessionId',$encryptedSession);

                return redirect()->route('2fa');
            }

            $newSession = Sessions::create([
                'UserId' => $user->Id,
                'Ip' => $ip,
                'Authenticated' => 1
            ]);

            $encryptedSession = $cryptor->encrypt($newSession->Id);
            \Session::put('sessionId',$encryptedSession);

            $intended = \Session::pull('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * generateTwoFactorPage
     * Route for generating the 2FA page.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateTwoFactorPage() {
        try {
            if(\Session::has('sessionId')) {
                $cryptor = new Cryptor();

                $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
                $session = Sessions::where('Id',$sessionId)->first();

                $sessionCheck = self::activeSessionCheck($session);
                if(!is_null($sessionCheck)) {
                    return $sessionCheck;
                }

                if(!is_null($session->TwoFactorId)) {
                    return view('auth.2fa');
                }
            }
            return redirect()->route('login');

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * twoFactorVerify
     * Validates the 2FA code to authenticate the user.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function twoFactorVerify(Request $request) {
        try {
            if(!\Session::has('sessionId')) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
            $session = Sessions::where('Id',$sessionId)->first();

            $sessionCheck = self::activeSessionCheck($session);
            if(!is_null($sessionCheck)) {
                return $sessionCheck;
            }

            $twoFactor = Two_Factor::where([
                'UserId' => $session->UserId, 'Ip' => $_SERVER['REMOTE_ADDR']
            ])->first();

            if(!password_verify($request->input('codeText'),$twoFactor->Code)) {
                return redirect()->route('2fa');
            }

            $session->update([
                'TwoFactorId' => null,
                'Authenticated' => 1
            ]);

            $twoFactor->delete();

            $intended = \Session::get('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * resend2FA
     * Generates and sends a new 2FA code.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function resend2FA() {
        try {
            if(!\Session::has('sessionId')) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
            $session = Sessions::where('Id',$sessionId)->first();

            $sessionCheck = self::activeSessionCheck($session);
            if(!is_null($sessionCheck)) {
                return $sessionCheck;
            }

            $user = User::where('Id',$session->UserId)->first();
            if(empty($user)) {
                return redirect()->route('login');
            }

            $twoFactor = Two_Factor::where([
                'UserId' => $session->UserId, 'Ip' => $_SERVER['REMOTE_ADDR']
            ])->first();
            if(!empty($twoFactor)) {
                $twoFactor->delete();
            }

            $code = RandomObjectGeneration::random_str(6, '1234567890');
            Two_Factor::create([
                'UserID' => $session->UserId,
                'Ip' => $_SERVER['REMOTE_ADDR'],
                'Code' => password_hash($code,PASSWORD_DEFAULT)
            ]);

            EmailController::sendTwoFactorEmail($user,$code);
            return redirect()->route('2fa');

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * activeSessionCheck
     * Helper function to check session objects.
     *
     * @param   $session            The session to check.
     * @return  \Illuminate\Http\RedirectResponse | null
     */
    private static function activeSessionCheck($session) {
        if($session->Ip !== $_SERVER['REMOTE_ADDR']) {
            $session->delete();
            \Session::forget('sessionId');
            return redirect()->route('login');
        }

        if($session->Authenticated === 1) {
            return redirect()->route('authHome');
        }
        return null;
    }

    /**
     * check
     * Validates if the user is authenticated on this IP Address.
     *
     * @return  bool
     */
    public static function check() {
        if(!\Session::has('sessionId')) {
            return false;
        }
        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('Id', $sessionId)->first();

        if($session->Ip !== $_SERVER['REMOTE_ADDR']) {
            $session->delete();
            \Session::forget('sessionId');
            return false;
        }
        return true;
    }

    /**
     * adminCheck
     * Validates if the user is an authenticated admin user.
     *
     * @return bool
     */
    public static function adminCheck() {
        $check = self::check();
        if(!$check) {
            return $check;
        }

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('Id', $sessionId)->first();

        $user = User::where('Id',$session->UserId)->first();
        if(empty($user)) {
            $session->delete();
            \Session::forget('sessionId');
            return false;
        }

        if($user->UserType !== 1) {
            return false;
        }
        return true;
    }

    /**
     * logout
     * Removes session variables storing the authenticated account.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function logout() {
        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        Sessions::where('Id', $sessionId)->first()->delete();
        \Session::forget('sessionId');

        return redirect()->route('login');
    }

    /**
     * generateLogin
     * Generates the login page.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateLogin() {
        if(self::check()) {
            return redirect()->route('authHome');
        }
        return view('auth.login');
    }

    /**
     * generateRegister
     * Generates the register page if the user is an admin.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateRegister() {
        if(self::adminCheck()) {
            $permissions = User_Permissions::all();
            $variables = array('permissions'=>$permissions);
            return view('auth.register')->with($variables);
        }
        return abort('401');
    }
}
