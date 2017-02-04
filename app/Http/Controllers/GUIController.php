<?php

namespace App\Http\Controllers;

use App\Libraries\RandomObjectGeneration;
use App\Models\Default_Settings;
use App\Models\Mailing_List_User;
use App\Models\MLU_Departments;
use App\Models\Campaign;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\User;
use League\Flysystem\Exception;

class GUIController extends Controller
{
    public static function generateLogin() {
        if(!Auth::check()) {
            return view("auth.login");
        }
        return redirect()->to('/');
    }

    public static function generateRegister() {
        if(!Auth::check()) {
            return view("auth.register");
        }
        return redirect()->to('/');
    }

    private static function authRequired() {
        \Session::put('intended',$_SERVER['REQUEST_URI']);
        return redirect()->route('login');
    }

    public static function displayResults() {
        if(Auth::check()) {
            return view("displays.showReports");
        }
        return self::authRequired();
    }

    public static function displayCampaigns() {
        if(Auth::check()) {
            return view("displays.showAllCampaigns");
        }
        return self::authRequired();
    }

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

    public static function generateCreateTemplate() {
        if(Auth::check()) {
            return view("forms.createNewTemplate");
        }
        return self::authRequired();
    }

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

    public static function updateCampaign(Request $request,$Id) {
        if(Auth::check()) {
            $campaign = Campaign::where('Id',$Id)->first();
            $description = $request->input('descriptionText');
            $userId = $request->input('userIdText');
            $status = $request->input('statusSelect');

            Campaign::updateCampaign($campaign, $description, $userId, $status);
            return redirect()->route('campaigns');
        }
        return self::authRequired();
    }

    /**
     * generatePhishingEmailForm
     * Generates the Send Phishing Email Request Form in the GUI.
     *
     * @return  \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public static function generatePhishingEmailForm() {
        if(Auth::check()) {
            $user = \Session::get('authUser');
            $settings = Default_Settings::where('UserId',$user->Id)->first();
            $campaigns = Campaign::all();
            $templates = self::returnAllTemplatesByDirectory('phishing');
            if(count($settings)) {
                $dft_host = $settings->MailServer;
                $dft_port = $settings->MailPort;
                $dft_user = $settings->Username;
                $dft_company = $settings->CompanyName;
            } else {
                $dft_host = '';
                $dft_port = '';
                $dft_company = '';
                $dft_user = '';
            }
            $variables = array('dft_host'=>$dft_host,'dft_port'=>$dft_port,'dft_user'=>$dft_user,
                'dft_company'=>$dft_company,'campaigns'=>$campaigns,'templates'=>$templates);
            return view('forms.phishingEmail')->with($variables);
        }
        return self::authRequired();
    }

    public static function generateEmailReportForm() {
        if(Auth::check()) {
            $campaigns = Campaign::all();
            $users = Mailing_List_User::all();
            $variables = array('campaigns'=>$campaigns,'users'=>$users);
            return view('forms.generateEmailReport')->with($variables);
        }
        return self::authRequired();
    }

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
     * updateDefaultEmailSettings
     * Post function for updating Default Email Settings, which are used to autofill the Send Email Request Form
     *
     * @param   Request         $request            Settings sent from form
     */
    public static function updateDefaultEmailSettings(Request $request) {
        $user = User::where('Username',$request->input('usernameText'))->first();
        $company = $request->input('companyText');
        $host = $request->input('mailServerText');
        $port = $request->input('mailPortText');

        $settings = Default_Settings::firstOrNew(['UserId'=>$user->Id]);
        $settings->DFT_MailServer = $host;
        $settings->DFT_MailPort = $port;
        $settings->DFT_CompanyName = $company;
        $settings->DFT_Username = $user->USR_Username;
        $settings->save();
    }

    /**
     * generateDefaultEmailSettingsForm
     * Generates the Settings form based on input from the database.
     *
     * @return  \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public static function generateDefaultEmailSettingsForm() {
        if(Auth::check()) {
            $user = \Session::get('authUser');
            $settings = Default_Settings::where('UserId',$user->Id)->first();
            if(count($settings)) {
                $dft_host = $settings->MailServer;
                $dft_port = $settings->MailPort;
                $dft_user = $settings->Username;
                $dft_company = $settings->CompanyName;
            } else {
                $dft_host = '';
                $dft_port = '';
                $dft_company = '';
                $dft_user = '';
            }
            $variables = array('dft_host'=>$dft_host,'dft_port'=>$dft_port,'dft_user'=>$dft_user,'dft_company'=>$dft_company);
            return view('forms.defaultEmailSettings')->with($variables);
        } else {
            \Session::put('intended',route('defaultSettings')); //define route defaultSettings
            return redirect()->route('login');
        }
    }

    /**
     * createNewPhishTemplate
     * Creates new phishing template and writes it to the file structure.
     *
     * @param   Request         $request        Template name and content sent by user to create new template
     */
    public static function createNewPhishTemplate(Request $request) {
        $name = $request->input('templateName');
        $content = $request->input('templateContent');
        Template::createPhish($content,$name);
    }

    /**
     * createNewEduTemplate
     * Creates new educational template and writes it to the file structure.
     *
     * @param   Request         $request        Template name and content sent by user to create new template
     */
    public static function createNewEduTemplate(Request $request) {
        $name = $request->input('templateName');
        $content = $request->input('templateContent');
        Template::createEdu($content,$name);
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

    /**
     * returnAllTemplatesByDirectory
     * Helper function that queries template names from specific directory in file structure.
     *
     * @param   string      $directory          Directory name
     * @return  array
     */
    private static function returnAllTemplatesByDirectory($directory) {
        $files = [];
        $fileNames = [];
        $filesInFolder = \File::files("../resources/views/emails/$directory");
        foreach($filesInFolder as $path) {
            $files[] = pathinfo($path);
        }
        for($i = 0; $i < sizeof($files); $i++) {
            $fileNames[$i] = $files[$i]['filename'];
            $fileNames[$i] = substr($fileNames[$i],0,-6);
        }
        return $fileNames;
    }

    /**
     * phishHTMLReturner
     * Takes phishing template name as input and returns content of template to
     * be used as a preview in the GUI.
     *
     * @param   string      $id             Template Name
     * @return  string                      Template Content
     */
    public static function phishHTMLReturner($id) {
        try {
            if(Auth::check()) {
                $path = "../resources/views/emails/phishing/$id.blade.php";
                $contents = \File::get($path);
            } else {
                $contents = "Failed user authentication.";
            }
        }
        catch (Exception $e) {
            //log exception
            $contents = "Preview Unavailable";
        }
        return $contents;
    }

    public static function generateNewMailingListUserForm() {
        if(Auth::check()) {
            $departments = MLU_Departments::all();
            $variables = array('departments'=>$departments);
            return view('forms.addNewMailingListUser')->with($variables);
            //return $variables;
        } else {
            \Session::put('intended',route('mailingListUser'));
            return redirect()->route('login');
        }
    }

    public static function createNewMailingListUser(Request $request) {
        if($request->input('departmentSelect') == 0) {
            $name = $request->input('createNewDepartmentText');
            $id = MLU_Departments::create(['Department'=>$name]);
            $department = MLU_Departments::where('Id',$id->Id)->first();
        } else {
            $department = MLU_Departments::where('Id',$request->input('departmentSelect'))->first();
        }
        Mailing_List_User::create(
            ['Username'=>$request->input('usernameText'),
                'Email'=>$request->input('emailText'),
                'FirstName'=>$request->input('firstNameText'),
                'LastName'=>$request->input('lastNameText'),
                'Department'=>$department->Id,
                'UniqueURLId'=>RandomObjectGeneration::random_str(30)]
        );
        return redirect()->route('mailingListUser');
    }

    public static function updateUser(Request $request) {
        if(Auth::check()) {
            $email = $request->input('emailText');
            $password = $request->input('passwordText');
            $twoFactor = $request->input('twoFactorToggle');
            if(!empty($twoFactor)) {
                $twoFactor = $twoFactor == 'true' ? true : false;
            }
            $user = \Session::get('authUser');

            User::updateUser($user, $email, password_hash($password, PASSWORD_DEFAULT), $twoFactor);
        }
    }

    public static function updateMailingListUser(Request $request) {

    }

    public static function generateUpdateMailingListUserForm() {

    }
}
