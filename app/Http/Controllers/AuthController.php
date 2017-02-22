<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Libraries\ErrorLogging;
use App\Libraries\RandomObjectGeneration;
use App\Models\Company;
use App\Models\Sessions;
use App\Models\Two_Factor;
use App\Models\User;
use App\Models\User_Permissions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * create
     * Create a new user instance after a valid registration.
     *
     * @param   Request       $request
     * @return  User | RedirectResponse
     */
    public static function create(Request $request) {
        try {
            $validator = Validator::make($request->all(),[
                'emailText' => 'bail|required|email|unique:users,email',
                'confirmEmailText' => 'bail|same:emailText',
                'firstNameText' => 'bail|required',
                'lastNameText' => 'bail|required',
                'middleInitialText' => 'bail|max:1',
                'permissionsSelect' => 'bail|required'
            ]);
            if($validator->fails()) {
                return redirect()->route('users');
            }

            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
            $session = Sessions::where('id', $sessionId)->first();

            $user = User::where('id',$session->user_id)->first();
            if(empty($user)) {
                return self::logout();
            }

            if($user->company_id !== 1) {
                $company = Company::where('id', $user->company_id)->first();
                if (empty($company)) {
                    return self::logout();
                }
                $company = $company->id;

            } else {
                $company = $request->input('companyText');
            }

            $password = RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_PASSWORDS')),true);

            $user = User::create([
                'email' => $request->input('emailText'),
                'first_name' => $request->input('firstNameText'),
                'last_name' => $request->input('lastNameText'),
                'middle_initial' => $request->input('middleInitialText'),
                'password' => password_hash($password,PASSWORD_DEFAULT),
                'two_factor_enabled' => 0,
                'user_type' => $request->input('permissionsSelect'),
                'company_id' => $company
            ]);

            EmailController::sendNewAccountEmail($user,$password);
            return redirect()->route('users');

        } catch(\Exception $e) {
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
            $validator = Validator::make($request->all(),[
                'emailText' => 'bail|required|email',
                'passwordText' => 'bail|required'
            ]);
            if($validator->fails()) {
                return redirect()->route('login');
            }

            $user = User::where('email',$request->input('emailText'))->first();
            $password = $request->input('passwordText');

            if(empty($user) || !password_verify($password,$user->password)) {
                return redirect()->route('login');
            }

            User::updateUser($user,$user->email,password_hash($password,PASSWORD_DEFAULT),$user->two_factor_enabled);

            $session = Sessions::where('user_id',$user->id)->first();
            if(!empty($session)) {
                $session->delete();
            }

            $ip = $_SERVER['REMOTE_ADDR'];
            $cryptor = new Cryptor();

            if($user->two_factor_enabled === 1) {
                $twoFactor = Two_Factor::where([
                    'user_id' => $user->id, 'ip_address' => $ip
                ])->first();
                if(!empty($twoFactor)) {
                    $twoFactor->delete();
                }

                $code = RandomObjectGeneration::random_str(6,false,'1234567890');
                $twoFactor = Two_Factor::create([
                    'user_id' => $user->id,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'code' => password_hash($code,PASSWORD_DEFAULT)
                ]);

                EmailController::sendTwoFactorEmail($user,$code);

                $newSession = Sessions::create([
                    'user_id' => $user->id,
                    'ip_address' => $ip,
                    'two_factor_id' => $twoFactor->id,
                    'authenticated' => 0
                ]);

                $encryptedSession = $cryptor->encrypt($newSession->id);
                \Session::put('sessionId',$encryptedSession);

                return redirect()->route('2fa');
            }

            $newSession = Sessions::create([
                'user_id' => $user->id,
                'ip_address' => $ip,
                'authenticated' => 1
            ]);

            $encryptedSession = $cryptor->encrypt($newSession->id);
            \Session::put('sessionId',$encryptedSession);

            $intended = \Session::pull('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');

        } catch(\Exception $e) {
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
            $sessionId = \Session::get('sessionId');
            if($sessionId) {
                $cryptor = new Cryptor();

                $sessionId = $cryptor->decrypt($sessionId);
                $session = Sessions::where('id',$sessionId)->first();

                $sessionCheck = self::activeSessionCheck($session);
                if(!is_null($sessionCheck)) {
                    return $sessionCheck;
                }

                if(!is_null($session->two_factor_id)) {
                    return view('auth.2fa');
                }
            }
            return redirect()->route('login');

        } catch(\Exception $e) {
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
            $validator = Validator::make($request->all(),[
                'codeText' => 'bail|required|digits:6'
            ]);
            if($validator->fails()) {
                return redirect()->route('login');
            }

            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            $session = Sessions::where('id',$sessionId)->first();

            $sessionCheck = self::activeSessionCheck($session);
            if(!is_null($sessionCheck)) {
                return $sessionCheck;
            }

            $twoFactor = Two_Factor::where([
                'user_id' => $session->user_id, 'ip_address' => $_SERVER['REMOTE_ADDR']
            ])->first();

            if(!password_verify($request->input('codeText'),$twoFactor->code)) {
                return redirect()->route('2fa');
            }

            $session->update([
                'two_factor_id' => null,
                'authenticated' => 1
            ]);

            $twoFactor->delete();

            $intended = \Session::pull('intended');
            if($intended) {
                return redirect()->to($intended);
            }
            return redirect()->route('authHome');

        } catch(\Exception $e) {
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
            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            $session = Sessions::where('id',$sessionId)->first();

            $sessionCheck = self::activeSessionCheck($session);
            if(!is_null($sessionCheck)) {
                return $sessionCheck;
            }

            $user = User::where('id',$session->user_id)->first();
            if(empty($user)) {
                return self::logout();
            }

            $twoFactor = Two_Factor::where([
                'user_id' => $session->user_id, 'ip_address' => $_SERVER['REMOTE_ADDR']
            ])->first();
            if(!empty($twoFactor)) {
                $twoFactor->delete();
            }

            $code = RandomObjectGeneration::random_str(6, '1234567890');
            Two_Factor::create([
                'user_id' => $session->user_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'code' => password_hash($code,PASSWORD_DEFAULT)
            ]);

            EmailController::sendTwoFactorEmail($user,$code);
            return redirect()->route('2fa');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * activeSessionCheck
     * Helper function to check session objects.
     *
     * @param   Sessions    $session            The session to check.
     * @return  \Illuminate\Http\RedirectResponse | null
     */
    private static function activeSessionCheck(Sessions $session) {
        if($session->ip_address !== $_SERVER['REMOTE_ADDR']) {
            $session->delete();
            \Session::forget('sessionId');
            return redirect()->route('login');
        }

        if($session->authenticated === 1) {
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
        try {
            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return false;
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            $session = Sessions::where('id', $sessionId)->first();

            if($session->ip_address !== $_SERVER['REMOTE_ADDR']) {
                $session->delete();
                \Session::forget('sessionId');
                return false;
            }
            return true;

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * adminCheck
     * Validates if the user is an authenticated admin user.
     *
     * @return bool
     */
    public static function adminCheck() {
        try {
            $check = self::check();
            if(!$check) {
                return $check;
            }

            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return false;
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            $session = Sessions::where('id', $sessionId)->first();

            $user = User::where('id',$session->user_id)->first();
            if(empty($user)) {
                $session->delete();
                \Session::forget('sessionId');
                return false;
            }

            if($user->user_type !== 1) {
                return false;
            }
            return true;

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * logout
     * Removes session variables storing the authenticated account.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function logout() {
        try {
            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            Sessions::where('id', $sessionId)->first()->delete();
            \Session::forget('sessionId');

            return redirect()->route('login');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * generateLogin
     * Generates the login page.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateLogin() {
        try {
            if(self::check()) {
                return redirect()->route('authHome');
            }
            return view('auth.login');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * generateRegister
     * Generates the register page if the user is an admin.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateRegister() {
        try {
            if(self::adminCheck()) {
                $permissions = User_Permissions::all();

                $companies = null;
                if(self::safephishAdminCheck()) {
                    $companies = Company::all();
                }

                $variables = array('permissions'=>$permissions,'companies'=>$companies);
                return view('auth.register')->with($variables);
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * authRequired
     * Adds session variable for return redirect and then redirects to login page.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function authRequired() {
        try {
            session(['intended' => $_SERVER['REQUEST_URI']]);
            return redirect()->route('login');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    public static function safephishAdminCheck() {
        try {
            $check = self::adminCheck();
            if(!$check) {
                return $check;
            }

            $sessionId = \Session::get('sessionId');
            if(!$sessionId) {
                return redirect()->route('login');
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt($sessionId);
            $session = Sessions::where('id', $sessionId)->first();

            $user = User::where('id',$session->user_id)->first();
            if(empty($user)) {
                $session->delete();
                \Session::forget('sessionId');
                return false;
            }

            if($user->user_type !== 1 || $user->company_id !== 1) {
                return false;
            }

            return true;

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }
}
