<?php

namespace App\Http\Controllers;

use App\Libraries\RandomObjectGeneration;
use App\Models\Campaign_Email_Addresses;
use App\Models\Mailing_List_User;
use App\Models\Mailing_List_User_Department_Bridge;
use App\Models\MLU_Departments;
use App\Models\Campaign;
use App\Models\Template;
use App\Models\User_Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\User;

class GUIController extends Controller
{
    /**
     * authRequired
     * Adds session variable for return redirect and then redirects to login page.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    private static function authRequired() {
        \Session::put('intended',$_SERVER['REQUEST_URI']);
        return redirect()->route('login');
    }

    /**
     * dashboard
     * Home route.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function dashboard() {
        if(Auth::check()) {
            return view("displays.dashboard");
        }
        return redirect()->route('login');
    }

    /**
     * displayCampaigns
     * Route to display all campaigns.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaigns() {
        if(Auth::check()) {
            return view("displays.showAllCampaigns");
        }
        return self::authRequired();
    }

    /**
     * displayCampaign
     * Display an individual campaign.
     *
     * @param   string      $Id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaign($Id) {
        if(Auth::check()) {
            $campaign = Campaign::where('Id',$Id)->first();
            $user = User::where('Id',$campaign->Assignee)->first();
            $users = User::all();
            $variables = array('campaign'=>$campaign,'user'=>$user,'users'=>$users);
            return view('forms.editCampaign')->with($variables);
        }
        return self::authRequired();
    }

    /**
     * updateCampaign
     * Update the campaign (selected by the param ID) with the request object.
     *
     * @param   Request         $request
     * @param   string          $Id
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function updateCampaign(Request $request,$Id) {
        if(Auth::check()) {
            $campaign = Campaign::where('Id',$Id)->first();
            $description = $request->input('descriptionText');
            $userId = $request->input('userIdText');
            $status = $request->input('statusSelect');

            Campaign::updateCampaign($campaign, $description, $userId, $status);
            return redirect()->route('campaigns');
        }
        return redirect()->route('login');
    }

    public static function createCampaignForm() {
        if(Auth::check()) {
            $users = User::all();
            $variables = array('users'=>$users);
            return view('forms.createCampaign')->with($variables);
        }
        return self::authRequired();
    }

    public static function createCampaign(Request $request) {
        if(Auth::check()) {
            $name = $request->input('nameText');
            $description = $request->input('descriptionText');
            $assignee = $request->input('assigneeText');
            Campaign::create([
                'Name'=>$name,
                'Description'=>$description,
                'Assignee'=>$assignee,
                'Status'=>'active'
            ]);
            return redirect()->route('createCampaign');
        }
        return redirect()->route('login');
    }

    /**
     * displayTemplates
     * Route to display all templates.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplates() {
        if(Auth::check()) {
            return view("displays.showAllTemplates");
        }
        return self::authRequired();
    }

    /**
     * displayTemplate
     * Display an individual template.
     *
     * @param   string      $FileName
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplate($FileName) {
        if(Auth::check()) {
            $template = Template::where('FileName',$FileName)->first();
            if(!is_null($template)) {
                $emailType = $template->EmailType;
                $file = explode("\n",file_get_contents("../resources/views/emails/$emailType/$FileName.blade.php"));
                $variables = array('templateText'=>$file,'publicName'=>$template->PublicName,'fileName'=>$FileName);
                return view('displays.showSelectedTemplate')->with($variables);
            }
            return redirect()->route('e404');
        }
        return self::authRequired();
    }

    /**
     * generateCreateTemplate
     * Route to template creation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateCreateTemplate() {
        if(Auth::check()) {
            return view("forms.createNewTemplate");
        }
        return self::authRequired();
    }

    public static function displayMLUs() {
        if(Auth::check()) {
            return view("displays.showAllMLU");
        }
        return self::authRequired();
    }

    /**
     * generatePhishingEmailForm
     * Generates the Send Phishing Email Request Form in the GUI.
     *
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public static function generatePhishingEmailForm() {
        if(Auth::check()) {
            $users = Mailing_List_User::all();
            $departments = MLU_Departments::all();
            $campaigns = Campaign::getAllActiveCampaigns();
            $templates = Template::all();
            $emails = Campaign_Email_Addresses::all();
            $variables = array('users'=>$users,'groups'=>$departments,'campaigns'=>$campaigns,
                'templates'=>$templates,'emails'=>$emails);
            return view('forms.generatePhishingEmails')->with($variables);
        }
        return self::authRequired();
    }

    /**
     * generateEmailReportForm
     * Route to display the email report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateEmailReportForm() {
        if(Auth::check()) {
            $campaigns = Campaign::all();
            $users = Mailing_List_User::all();
            $variables = array('campaigns'=>$campaigns,'users'=>$users);
            return view('forms.generateEmailReport')->with($variables);
        }
        return self::authRequired();
    }

    /**
     * generateWebsiteReportForm
     * Route to display the website report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateWebsiteReportForm() {
        if(Auth::check()) {
            $campaigns = Campaign::all();
            $users = Mailing_List_User::all();
            $variables = array('campaigns'=>$campaigns,'users'=>$users);
            return view('forms.generateWebsiteReport')->with($variables);
        }
        return self::authRequired();
    }

    /**
     * createNewCampaign
     * Creates new campaign and inserts into database.
     *
     * @param   Request         $request        Data sent by user to instantiate new campaign
     */
    public static function createNewCampaign(Request $request) {
        $user = \Session::get('authUser');
        Campaign::create(
            ['Name'=>$request->input('campaignName'),
            'Description'=>$request->input('campaignDescription'),
            'Assignee'=>$user->Id,
            'Status'=>'active']
        );
    }

    public static function generateNewMailingListUserForm() {
        if(Auth::check()) {
            $departments = MLU_Departments::all();
            $variables = array('departments'=>$departments);
            return view('forms.addNewMLU')->with($variables);
        }
        return self::authRequired();
    }

    public static function generateNewMailingListDepartmentForm() {
        if(Auth::check()) {
            $mlu = Mailing_List_User::all();
            $variables = array('users'=>$mlu);
            return view('forms.createMLUDepartment')->with($variables);
        }
        return self::authRequired();
    }

    public static function createNewMailingListUser(Request $request) {
        $mlu = Mailing_List_User::create(
            ['Email'=>$request->input('emailText'),
                'FirstName'=>$request->input('firstNameText'),
                'LastName'=>$request->input('lastNameText'),
                'UniqueURLId'=>RandomObjectGeneration::random_str(getenv('DEFAULT_LENGTH_IDS'))]
        );
        $departments = $request->input('departmentSelect');
        foreach($departments as $department) {
            Mailing_List_User_Department_Bridge::create(
                ['UserId'=>$mlu->Id,
                    'DepartmentId'=>$department]
            );
        }
        return redirect()->route('mailingListUser');
    }

    public static function createNewMailingListDepartment(Request $request) {
        $mlud = MLU_Departments::create([
            'Department'=>$request->input('nameText')
        ]);
        $users = $request->input('userSelect');
        foreach($users as $user) {
            Mailing_List_User_Department_Bridge::create(
                ['UserId'=>$user,
                    'DepartmentId'=>$mlud->Id]
            );
        }
        return redirect()->route('mailingListDepartment');
    }

    public static function updateMailingListUser(Request $request, $Id) {
        $mlu = Mailing_List_User::where('Id',$Id)->first();
        $email = $request->input('emailText');
        $urlToggle = $request->input('urlToggle');
        $fname = $request->input('firstNameText');
        $lname = $request->input('lastNameText');
        Mailing_List_User_Department_Bridge::where('UserId',$Id)->delete();
        $departments = $request->input('departmentSelect');
        foreach($departments as $department) {
            Mailing_List_User_Department_Bridge::create(
                ['UserId'=>$mlu->Id,
                    'DepartmentId'=>$department]
            );
        }
        if(!empty($urlToggle) && $urlToggle == 'on') {
            $url = RandomObjectGeneration::random_str(getenv('DEFAULT_LENGTH_IDS'));
            Mailing_List_User::updateMailingListUser($mlu,$email,$fname,$lname,$url);
        } else {
            Mailing_List_User::updateMailingListUser($mlu,$email,$fname,$lname);
        }
        return redirect()->route('mlu');
    }

    public static function generateUpdateMailingListUserForm($Id) {
        if(Auth::check()) {
            $mlu = Mailing_List_User::where('Id',$Id)->first();
            $departments = MLU_Departments::all();
            $variables = array('mlu'=>$mlu,'departments'=>$departments);
            return view('forms.editMLU')->with($variables);
        }
        return self::authRequired();
    }

    public static function displayMLUDs() {
        if(Auth::check()) {
            return view("displays.showAllMLUDepartments");
        }
        return self::authRequired();
    }

    public static function generateUpdateMLUDForm($Id) {
        if(Auth::check()) {
            $mlud = MLU_Departments::where('Id',$Id)->first();
            $users = Mailing_List_User::all();
            $variables = array('mlud'=>$mlud,'users'=>$users);
            return view('forms.editMLUDepartment')->with($variables);
        }
        return self::authRequired();
    }

    public static function updateMailingListDepartment(Request $request, $Id) {
        $department = $request->input('nameText');
        if(!empty($department)) {
            $query = MLU_Departments::query();
            $query->where('Id',$Id);
            $query->update(['Department'=>$department]);
            $query->get();
        }
        $users = $request->input('userSelect');
        $mlud = MLU_Departments::where('Id',$Id)->first();
        Mailing_List_User_Department_Bridge::where('DepartmentId',$Id)->delete();
        foreach($users as $user) {
            Mailing_List_User_Department_Bridge::create(
                ['UserId'=>$user,
                    'DepartmentId'=>$mlud->Id]
            );
        }
        return redirect()->route('mlud');
    }

    public static function updateUserAccountManagement(Request $request) {
        if(Auth::check()) {
            $email = $request->input('emailText');
            $password = $request->input('passwordText');
            $passwordVerify = $request->input('passwordVerifyText');
            $twoFactor = $request->input('twoFactorToggle');
            if(!empty($twoFactor)) {
                $twoFactor = $twoFactor == 'on' ? true : false;
            }
            $user = \Session::get('authUser');
            if($password != $passwordVerify) {
                return redirect()->route('accountManagement');
            }
            $user = User::updateUser($user, $email, password_hash($password, PASSWORD_DEFAULT), $twoFactor);
            \Session::put('authUser',$user->first());
            return redirect()->route('accountManagement');
        }
        return redirect()->route('login');
    }

    public static function accountManagementForm() {
        if(Auth::check()) {
            $user = \Session::get('authUser');
            $variables = array('user'=>$user);
            return view('forms.accountManagement')->with($variables);
        }
        return self::authRequired();
    }

    public static function updateUser(Request $request, $Id) {
        if(Auth::adminCheck()) {
            $email = $request->input('emailText');
            $password = $request->input('passwordToggle');
            if(!empty($password) && $password == 'on') {
                $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';
                $password = RandomObjectGeneration::random_str(intval(getenv('DEFAULT_LENGTH_PASSWORDS')),$keyspace);
            }
            $user = User::where('Id',$Id)->first();
            $userType = $request->input('permissionsText');
            if(!empty($userType)) {
                $userType = User_Permissions::where('Id',$userType)->first();
            }
            User::updateUser($user,$email,password_hash($password,PASSWORD_DEFAULT),'',$userType);
            EmailController::sendNewAccountEmail($user,$password);
            return redirect()->route('users');
        }
        return redirect()->route('e401');
    }

    public static function displayUsers() {
        if(Auth::adminCheck()) {
            return view('displays.showAllUsers');
        }
        return redirect()->route('e401');
    }

    public static function displayUser($Id) {
        if(Auth::adminCheck()) {
            $user = User::where('Id',$Id)->first();
            $twoFactor = $user->getAttribute('2FA');
            $twoFactor = $twoFactor == 0 ? 'Enabled' : 'Disabled';
            $permissions = User_Permissions::all();
            $variables = array('user'=>$user,'twoFactor'=>$twoFactor,'permissions'=>$permissions);
            return view('forms.editUser')->with($variables);
        }
        return redirect()->route('e401');
    }
}
