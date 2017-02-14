<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\Cryptor;
use App\Models\Campaign;
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view("displays.dashboard");
    }

    //Campaigns

    /**
     * displayCampaigns
     * Route to display all campaigns.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaigns() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }
        return view("displays.showAllCampaigns");
    }

    /**
     * displayCampaign
     * Display an individual campaign.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaign($id) {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $campaign = Campaign::where('id',$id)->first();
        $user = User::where('id',$campaign->assignee)->first();
        $users = User::all();

        $variables = array('campaign'=>$campaign,'user'=>$user,'users'=>$users);
        return view('forms.editCampaign')->with($variables);
    }

    /**
     * createCampaignForm
     * Create new campaigns.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function createCampaignForm() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $users = User::all();

        $variables = array('users'=>$users);
        return view('forms.createCampaign')->with($variables);
    }

    //Templates

    /**
     * displayTemplates
     * Route to display all templates.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplates() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }
        return view("displays.showAllTemplates");
    }

    /**
     * displayTemplate
     * Display an individual template.
     *
     * @param   string      $fileName
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplate($fileName) {
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
    }

    //Mailing List Users

    /**
     * displayMailingListUsers
     * Display all mailing list users.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayMailingListUsers() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }
        return view("displays.showAllMailingListUsers");
    }

    /**
     * createMailingListUserForm
     * Create new mailing list user.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function createMailingListUserForm() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $groups = Mailing_List_Groups::all();

        $variables = array('groups'=>$groups);
        return view('forms.addNewMailingListUser')->with($variables);
    }

    /**
     * updateMailingUserForm
     * Update mailing list user.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function updateMailingListUserForm($id) {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $mlu = Mailing_List_User::where('id',$id)->first();
        $groups = Mailing_List_Groups::all();

        $variables = array('mlu'=>$mlu,'groups'=>$groups);
        return view('forms.editMailingListUser')->with($variables);
    }

    //Mailing List Groups

    /**
     * displayMailingListGroups
     * Display all mailing list groups.
     *
     * @return \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayMailingListGroups() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }
        return view("displays.showAllMailingListGroups");
    }

    public static function createMailingListGroupForm() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $mlu = Mailing_List_User::all();

        $variables = array('users'=>$mlu);
        return view('forms.createMailingListGroup')->with($variables);
    }

    /**
     * updateMailingListGroupsForm
     * Update mailing list group.
     *
     * @param   string      $id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function updateMailingListGroupsForm($id) {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $group = Mailing_List_Groups::where('id',$id)->first();
        $users = Mailing_List_User::all();

        $variables = array('group'=>$group,'users'=>$users);
        return view('forms.editMailingListGroup')->with($variables);
    }

    //Phishing

    /**
     * displayPhishingEmailForm
     * Generates the Send Phishing Email Request Form in the GUI.
     *
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public static function displayPhishingEmailForm() {
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
    }

    //Reports

    /**
     * generateEmailReportForm
     * Route to display the email report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateEmailReportForm() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $campaigns = Campaign::all();
        $users = Mailing_List_User::all();

        $variables = array('campaigns'=>$campaigns,'users'=>$users);
        return view('forms.generateEmailReport')->with($variables);
    }

    /**
     * generateWebsiteReportForm
     * Route to display the website report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateWebsiteReportForm() {
        if(!Auth::check()) {
            return Auth::authRequired();
        }

        $campaigns = Campaign::all();
        $users = Mailing_List_User::all();

        $variables = array('campaigns'=>$campaigns,'users'=>$users);
        return view('forms.generateWebsiteReport')->with($variables);
    }

    //Users

    /**
     * accountManagementForm
     * Displays the account management page.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function accountManagementForm() {
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
    }

    /**
     * displayUsers
     * Displays all users.
     *
     * @return  \Illuminate\View\View
     */
    public static function displayUsers() {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to displayUsers" . PHP_EOL;
            $message .= "User either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }

        return view('displays.showAllUsers');
    }

    /**
     * displayUser
     * Displays a specific user.
     *
     * @param   string          $id
     * @return  \Illuminate\View\View
     */
    public static function displayUser($id) {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to updateUser" . PHP_EOL;
            $message .= "UserId, $id, either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }

        $user = User::where('id',$id)->first();
        $twoFactor = $user->two_factor_enabled;
        $twoFactor = $twoFactor == 0 ? 'Enabled' : 'Disabled';
        $permissions = User_Permissions::all();

        $variables = array('user'=>$user,'twoFactor'=>$twoFactor,'permissions'=>$permissions);
        return view('forms.editUser')->with($variables);
    }
}