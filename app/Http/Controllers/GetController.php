<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\Cryptor;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Sessions;
use App\Models\User;
use App\Models\Template;
use App\Models\Mailing_List_User;
use App\Models\Mailing_List_Groups;
use App\Models\Campaign_Email_Addresses;
use App\Models\User_Permissions;
use App\Libraries\ErrorLogging;
use League\Flysystem\FileNotFoundException;
use Illuminate\Validation\UnauthorizedException;

class GetController
{
    /**
     * dashboard
     * Home route.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function dashboard() {
        try {
            if(!Auth::check()) {
                return redirect()->route('login');
            }
            return view("displays.dashboard");

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Campaigns

    /**
     * displayCampaigns
     * Route to display all campaigns.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaigns() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            return view("displays.showAllCampaigns");

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * displayCampaign
     * Display an individual campaign.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaign($id) {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $campaign = Campaign::where('id',$id)->first();
            $user = User::where('id',$campaign->assignee)->first();
            $users = User::all();

            $variables = array('campaign'=>$campaign,'user'=>$user,'users'=>$users);
            return view('forms.editCampaign')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * createCampaignForm
     * Create new campaigns.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View | string
     */
    public static function createCampaignForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $users = User::queryUsers(true);

            $variables = array('users'=>$users);
            return view('forms.createCampaign')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Templates

    /**
     * displayTemplates
     * Route to display all templates.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplates() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            return view("displays.showAllTemplates");

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * displayTemplate
     * Display an individual template.
     *
     * @param   string      $fileName
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplate($fileName) {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            $template = Template::where('file_name',$fileName)->first();
            if(empty($template)) {
                ErrorLogging::logError(new FileNotFoundException($fileName));
                return abort('404');
            }

            $emailType = $template->email_type;
            $file = explode("\n",file_get_contents("../resources/views/emails/$emailType/$fileName.blade.php"));

            $variables = array('templateText'=>$file,'publicName'=>$template->public_name,'fileName'=>$fileName);
            return view('displays.showSelectedTemplate')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Mailing List Users

    /**
     * displayMailingListUsers
     * Display all mailing list users.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayMailingListUsers() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            return view("displays.showAllMailingListUsers");

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * createMailingListUserForm
     * Create new mailing list user.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function createMailingListUserForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $groups = Mailing_List_Groups::queryGroups();

            $companies = null;
            if(Auth::safephishAdminCheck()) {
                $companies = Company::all();
            }

            $variables = array('groups'=>$groups,'companies'=>$companies);
            return view('forms.addNewMailingListUser')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * updateMailingUserForm
     * Update mailing list user.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function updateMailingListUserForm($id) {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $mlu = Mailing_List_User::where('id',$id)->first();
            $groups = Mailing_List_Groups::queryGroups();

            $variables = array('mlu'=>$mlu,'groups'=>$groups);
            return view('forms.editMailingListUser')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Mailing List Groups

    /**
     * displayMailingListGroups
     * Display all mailing list groups.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayMailingListGroups() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            return view("displays.showAllMailingListGroups");

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    public static function createMailingListGroupForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $mlu = Mailing_List_User::queryMLU();

            $companies = null;
            if(Auth::safephishAdminCheck()) {
                $companies = Company::all();
            }

            $variables = array('users'=>$mlu,'companies'=>$companies);
            return view('forms.createMailingListGroup')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * updateMailingListGroupsForm
     * Update mailing list group.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function updateMailingListGroupsForm($id) {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $group = Mailing_List_Groups::where('id',$id)->first();
            $users = Mailing_List_User::queryMLU();

            $variables = array('group'=>$group,'users'=>$users);
            return view('forms.editMailingListGroup')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Phishing

    /**
     * displayPhishingEmailForm
     * Generates the Send Phishing Email Request Form in the GUI.
     *
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public static function displayPhishingEmailForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $users = Mailing_List_User::all();
            $groups = Mailing_List_Groups::all();
            $campaigns = Campaign::getAllActiveCampaigns();
            $templates = Template::all();
            $emails = Campaign_Email_Addresses::all();

            $variables = array('users'=>$users,'groups'=>$groups,'campaigns'=>$campaigns,
                'templates'=>$templates,'emails'=>$emails);
            return view('forms.generatePhishingEmails')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Reports

    /**
     * generateEmailReportForm
     * Route to display the email report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateEmailReportForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $campaigns = Campaign::all();
            $users = Mailing_List_User::all();

            $variables = array('campaigns'=>$campaigns,'users'=>$users);
            return view('forms.generateEmailReport')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * generateWebsiteReportForm
     * Route to display the website report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateWebsiteReportForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }

            $campaigns = Campaign::all();
            $users = Mailing_List_User::all();

            $variables = array('campaigns'=>$campaigns,'users'=>$users);
            return view('forms.generateWebsiteReport')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    //Users

    /**
     * accountManagementForm
     * Displays the account management page.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function accountManagementForm() {
        try {
            if(!Auth::check()) {
                return Auth::authRequired();
            }
            $cryptor = new Cryptor();

            $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
            $session = Sessions::where('id', $sessionId)->first();

            $user = User::where('id',$session->user_id)->first();
            if(empty($user)) {
                return Auth::logout();
            }

            $variables = array('user'=>$user);
            return view('forms.accountManagement')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * displayUsers
     * Displays all users.
     *
     * @return  \Illuminate\View\View
     */
    public static function displayUsers() {
        try {
            if(!Auth::adminCheck()) {
                $message = "Unauthorized Access to displayUsers" . PHP_EOL;
                $message .= "User either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
                ErrorLogging::logError(new UnauthorizedException($message));
                return abort('401');
            }

            return view('displays.showAllUsers');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * displayUser
     * Displays a specific user.
     *
     * @param   string          $id
     * @return  \Illuminate\View\View
     */
    public static function displayUser($id) {
        try {
            if(!Auth::adminCheck()) {
                $message = "Unauthorized Access to updateUser" . PHP_EOL;
                $message .= "UserId, $id, either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
                ErrorLogging::logError(new UnauthorizedException($message));
                return abort('401');
            }

            $user = User::where('id',$id)->first();
            $twoFactor = $user->two_factor_enabled;
            $twoFactor = $twoFactor == 0 ? 'Disabled' : 'Enabled';
            $permissions = User_Permissions::all();

            $variables = array('user'=>$user,'twoFactor'=>$twoFactor,'permissions'=>$permissions);
            return view('forms.editUser')->with($variables);

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }


    public static function createCampaignEmailAddress() {
        try {
            if(!Auth::adminCheck()) {
                $message = "Unauthorized Access to createCampaignEmailAddress (GET)" . PHP_EOL;
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
                $message = "Unauthorized Access to createCampaignEmailAddress (GET)" . PHP_EOL;
                $message .= "$user->id attempted to access." . PHP_EOL . PHP_EOL;
                ErrorLogging::logError(new UnauthorizedException($message));
                return abort('401');
            }

            return view('forms.createCampaignEmailAddress');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }
}