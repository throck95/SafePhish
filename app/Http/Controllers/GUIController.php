<?php

namespace App\Http\Controllers;

use App\Libraries\ErrorLogging;
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
use Illuminate\Validation\UnauthorizedException;
use League\Flysystem\FileNotFoundException;

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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view("displays.dashboard");
    }

    /**
     * displayCampaigns
     * Route to display all campaigns.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaigns() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        return view("displays.showAllCampaigns");
    }

    /**
     * displayCampaign
     * Display an individual campaign.
     *
     * @param   string      $Id
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayCampaign($Id) {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $campaign = Campaign::where('Id',$Id)->first();
        $user = User::where('Id',$campaign->Assignee)->first();
        $users = User::all();
        $variables = array('campaign'=>$campaign,'user'=>$user,'users'=>$users);
        return view('forms.editCampaign')->with($variables);
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        $campaign = Campaign::where('Id',$Id)->first();
        $description = $request->input('descriptionText');
        $userId = $request->input('userIdText');
        $status = $request->input('statusSelect');

        Campaign::updateCampaign($campaign, $description, $userId, $status);
        return redirect()->route('campaigns');
    }

    public static function createCampaignForm() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $users = User::all();
        $variables = array('users'=>$users);
        return view('forms.createCampaign')->with($variables);
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
            'Name'=>$name,
            'Description'=>$description,
            'Assignee'=>$assignee,
            'Status'=>'active'
        ]);
        return redirect()->route('createCampaign');
    }

    /**
     * displayTemplates
     * Route to display all templates.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplates() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        return view("displays.showAllTemplates");
    }

    /**
     * displayTemplate
     * Display an individual template.
     *
     * @param   string      $FileName
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function displayTemplate($FileName) {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $template = Template::where('FileName',$FileName)->first();
        if(empty($template)) {
            ErrorLogging::logError(new FileNotFoundException($FileName));
            return abort('404');
        }
        $emailType = $template->EmailType;
        $file = explode("\n",file_get_contents("../resources/views/emails/$emailType/$FileName.blade.php"));
        $variables = array('templateText'=>$file,'publicName'=>$template->PublicName,'fileName'=>$FileName);
        return view('displays.showSelectedTemplate')->with($variables);
    }

    /**
     * generateCreateTemplate
     * Route to template creation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateCreateTemplate() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        return view("forms.createNewTemplate");
    }

    public static function displayMLUs() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        return view("displays.showAllMLU");
    }

    /**
     * generatePhishingEmailForm
     * Generates the Send Phishing Email Request Form in the GUI.
     *
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public static function generatePhishingEmailForm() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $users = Mailing_List_User::all();
        $departments = MLU_Departments::all();
        $campaigns = Campaign::getAllActiveCampaigns();
        $templates = Template::all();
        $emails = Campaign_Email_Addresses::all();
        $variables = array('users'=>$users,'groups'=>$departments,'campaigns'=>$campaigns,
            'templates'=>$templates,'emails'=>$emails);
        return view('forms.generatePhishingEmails')->with($variables);
    }

    /**
     * generateEmailReportForm
     * Route to display the email report generation.
     *
     * @return  \Illuminate\Http\RedirectResponse | \Illuminate\View\View
     */
    public static function generateEmailReportForm() {
        if(!Auth::check()) {
            return self::authRequired();
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
            return self::authRequired();
        }
        $campaigns = Campaign::all();
        $users = Mailing_List_User::all();
        $variables = array('campaigns'=>$campaigns,'users'=>$users);
        return view('forms.generateWebsiteReport')->with($variables);
    }

    public static function generateNewMailingListUserForm() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $departments = MLU_Departments::all();
        $variables = array('departments'=>$departments);
        return view('forms.addNewMLU')->with($variables);
    }

    public static function generateNewMailingListDepartmentForm() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $mlu = Mailing_List_User::all();
        $variables = array('users'=>$mlu);
        return view('forms.createMLUDepartment')->with($variables);
    }

    public static function createNewMailingListUser(Request $request) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
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
        if(!Auth::check()) {
            return self::authRequired();
        }
        $mlu = Mailing_List_User::where('Id',$Id)->first();
        $departments = MLU_Departments::all();
        $variables = array('mlu'=>$mlu,'departments'=>$departments);
        return view('forms.editMLU')->with($variables);
    }

    public static function displayMLUDs() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        return view("displays.showAllMLUDepartments");
    }

    public static function generateUpdateMLUDForm($Id) {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $mlud = MLU_Departments::where('Id',$Id)->first();
        $users = Mailing_List_User::all();
        $variables = array('mlud'=>$mlud,'users'=>$users);
        return view('forms.editMLUDepartment')->with($variables);
    }

    public static function updateMailingListDepartment(Request $request, $Id) {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
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
        if(!Auth::check()) {
            return redirect()->route('login');
        }
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

    public static function accountManagementForm() {
        if(!Auth::check()) {
            return self::authRequired();
        }
        $user = \Session::get('authUser');
        $variables = array('user'=>$user);
        return view('forms.accountManagement')->with($variables);
    }

    public static function updateUser(Request $request, $Id) {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to updateUser" . PHP_EOL;
            $message .= "UserId, $Id, either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }
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

    public static function displayUsers() {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to displayUsers" . PHP_EOL;
            $message .= "User either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }
        return view('displays.showAllUsers');
    }

    public static function displayUser($Id) {
        if(!Auth::adminCheck()) {
            $message = "Unauthorized Access to updateUser" . PHP_EOL;
            $message .= "UserId, $Id, either doesn't have permission, doesn't exist, or their session expired." . PHP_EOL . PHP_EOL;
            ErrorLogging::logError(new UnauthorizedException($message));
            return abort('401');
        }
        $user = User::where('Id',$Id)->first();
        $twoFactor = $user->getAttribute('2FA');
        $twoFactor = $twoFactor == 0 ? 'Enabled' : 'Disabled';
        $permissions = User_Permissions::all();
        $variables = array('user'=>$user,'twoFactor'=>$twoFactor,'permissions'=>$permissions);
        return view('forms.editUser')->with($variables);
    }
}
