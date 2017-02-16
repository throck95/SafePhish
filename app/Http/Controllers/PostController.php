<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Libraries\ErrorLogging;
use App\Libraries\RandomObjectGeneration;
use App\Models\Campaign_Email_Addresses;
use App\Models\Company;
use App\Models\Mailing_List_User;
use App\Models\Mailing_List_Users_Groups_Bridge;
use App\Models\Mailing_List_Groups;
use App\Models\User_Permissions;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Sessions;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{

    /**
     * updateCampaign
     * Update the campaign (selected by the param ID) with the request object.
     *
     * @param   Request         $request
     * @param   string          $id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateCampaign(Request $request,$id) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $campaign = Campaign::where('id',$id)->first();
        $description = $request->input('descriptionText');
        $userId = $request->input('userIdText');
        $status = $request->input('statusSelect');

        Campaign::updateCampaign($campaign, $description, $userId, $status);

        return redirect()->route('campaigns');
    }

    /**
     * createCampaign
     * Creates new campaign and inserts into database.
     *
     * @param   Request         $request        Data sent by user to instantiate new campaign
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function createCampaign(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $name = $request->input('nameText');
        $description = $request->input('descriptionText');
        $assignee = $request->input('assigneeText');

        Campaign::create([
            'name'=>$name,
            'description'=>$description,
            'assignee'=>$assignee,
            'status'=>'active'
        ]);

        return redirect()->route('campaigns');
    }

    /**
     * createMailingListUser
     * Creates new mailing list user.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function createMailingListUser(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        $user = User::where('id',$session->user_id)->first();
        if(empty($user)) {
            return Auth::logout();
        }

        if($user->company_id !== 1) {
            $company = Company::where('id',$user->company_id)->first();
            if(empty($company)) {
                return Auth::logout();
            }

            $mailingListUser = Mailing_List_User::create(
                [
                    'company_id'=>$company->id,
                    'email'=>$request->input('emailText'),
                    'first_name'=>$request->input('firstNameText'),
                    'last_name'=>$request->input('lastNameText'),
                    'unique_url_id'=>RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_IDS')))
                ]);

        } else {

            $mailingListUser = Mailing_List_User::create(
                [
                    'company_id'=>$request->input('companyText'),
                    'email'=>$request->input('emailText'),
                    'first_name'=>$request->input('firstNameText'),
                    'last_name'=>$request->input('lastNameText'),
                    'unique_url_id'=>RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_IDS')))
                ]);
        }

        $groups = $request->input('groupSelect');
        if(!empty($groups)) {
            foreach($groups as $group) {
                Mailing_List_Users_Groups_Bridge::create(
                    ['mailing_list_user_id'=>$mailingListUser->id,
                        'group_id'=>$group]
                );
            }
        }

        return redirect()->route('mailingListUser');
    }

    /**
     * createMailingListGroup
     * Creates new mailing list group.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function createMailingListGroup(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        $user = User::where('id',$session->user_id)->first();
        if(empty($user)) {
            return Auth::logout();
        }

        if($user->company_id !== 1) {
            $company = Company::where('id', $user->company_id)->first();
            if (empty($company)) {
                return Auth::logout();
            }

            $group = Mailing_List_Groups::create([
                'company_id'=>$company->id,
                'name'=>$request->input('nameText')
            ]);

        } else {

            $group = Mailing_List_Groups::create([
                'company_id'=>$request->input('companyText'),
                'name'=>$request->input('nameText')
            ]);
        }

        $users = $request->input('userSelect');
        foreach($users as $mlu) {
            Mailing_List_Users_Groups_Bridge::create(
                ['mailing_list_user_id'=>$mlu,
                    'group_id'=>$group->id]
            );
        }

        return redirect()->route('mailingListGroup');
    }

    /**
     * updateMailingListUser
     * Updates an existing mailing list user.
     *
     * @param   Request         $request
     * @param   string          $id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateMailingListUser(Request $request, $id) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $mailing_list_user = Mailing_List_User::where('id',$id)->first();
        $email = $request->input('emailText');
        $urlToggle = $request->input('urlToggle');
        $fname = $request->input('firstNameText');
        $lname = $request->input('lastNameText');

        Mailing_List_Users_Groups_Bridge::where('mailing_list_user_id',$id)->delete();

        $groups = $request->input('groupSelect');
        foreach($groups as $group) {
            Mailing_List_Users_Groups_Bridge::create(
                ['mailing_list_user_id'=>$mailing_list_user->id,
                    'group_id'=>$group]
            );
        }

        if(!empty($urlToggle) && $urlToggle === 'on') {
            $url = RandomObjectGeneration::random_str(getenv('DEFAULT_LENGTH_IDS'));
            Mailing_List_User::updateMailingListUser($mailing_list_user,$email,$fname,$lname,$url);
        } else {
            Mailing_List_User::updateMailingListUser($mailing_list_user,$email,$fname,$lname);
        }

        return redirect()->route('mailing_list_user');
    }

    /**
     * updateMailingListGroup
     * Updates an existing mailing list group.
     *
     * @param   Request         $request
     * @param   string          $id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateMailingListGroup(Request $request, $id) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        $name = $request->input('nameText');
        if(!empty($name)) {
            $query = Mailing_List_Groups::query();
            $query->where('id',$id);
            $query->update(['name'=>$name]);
            $query->get();
        }

        $users = $request->input('userSelect');
        $group = Mailing_List_Groups::where('id',$id)->first();
        Mailing_List_Users_Groups_Bridge::where('group_id',$id)->delete();
        if(!empty($group)) {
            foreach($users as $user) {
                Mailing_List_Users_Groups_Bridge::create(
                    ['mailing_list_user_id'=>$user,
                        'group_id'=>$group->id]
                );
            }
        }

        return redirect()->route('mailingListGroup');
    }

    /**
     * updateUserAccountManagement
     * User updates their own account.
     *
     * @param   Request         $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateUserAccountManagement(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        $user = User::where('id',$session->user_id)->first();
        if(empty($user)) {
            return Auth::logout();
        }

        $email = $request->input('emailText');
        $password = $request->input('passwordText');
        $passwordVerify = $request->input('passwordVerifyText');

        $twoFactor = $request->input('twoFactorToggle');
        if(!empty($twoFactor)) {
            $twoFactor = $twoFactor === 'on' ? true : false;
        }

        if($password != $passwordVerify) {
            return redirect()->route('accountManagement');
        }

        User::updateUser($user, $email, password_hash($password, PASSWORD_DEFAULT), $twoFactor);

        return redirect()->route('accountManagement');
    }

    /**
     * updateUser
     * Admin updates a user account.
     *
     * @param   Request         $request
     * @param   string          $id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateUser(Request $request, $id) {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to updateUser" . PHP_EOL;
            $message .= "UserId, $id, either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }

        $password = $request->input('passwordToggle');
        if(!empty($password) && $password === 'on') {
            $password = RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_PASSWORDS')),true);
        }

        $userType = $request->input('permissionsText');
        if(!empty($userType)) {
            $userType = User_Permissions::where('id',$userType)->first();
        }

        $user = User::where('id',$id)->first();
        $email = $request->input('emailText');
        User::updateUser($user,$email,password_hash($password,PASSWORD_DEFAULT),'',$userType);

        EmailController::sendNewAccountEmail($user,$password);

        return redirect()->route('users');
    }


    public static function createCampaignEmailAddress(Request $request) {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to createCampaignEmailAddress (POST)" . PHP_EOL;
            $message .= "UserId either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }

        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        $user = User::where('id',$session->user_id)->first();
        if(empty($user)) {
            return Auth::logout();
        }

        if($user->id !== 1) {
            $message = "Unauthorized Access to createCampaignEmailAddress (POST)" . PHP_EOL;
            $message .= "$user->id attempted to access." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }

        Campaign_Email_Addresses::create([
            'email_address'=>$request->input('emailText'),
            'name'=>$request->input('nameText'),
            'password'=>$cryptor->encrypt($request->input('passwordText'))
        ]);

        return redirect()->route('createCampaignEmails');
    }
}
