<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Libraries\ErrorLogging;
use App\Mail as MailTemplates;
use App\Models\Campaign_Email_Addresses;
use App\Models\Mailing_List_Groups;
use App\Models\Mailing_List_Users_Groups_Bridge;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\Campaign;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Exception;

class EmailController extends Controller
{
    /**
     * sendEmail
     * Function updates ENV objects required for email authentication, then sends the email.
     *
     * @param   Request     $request        Request object passed via AJAX from client.
     * @return  \Illuminate\Http\RedirectResponse
     */
    public static function sendPhishingEmail(Request $request) {
        try {
            if(!Auth::check()) {
                return redirect()->route('login');
            }

            $fromEmail = Campaign_Email_Addresses::where('email_address',$request->input('fromEmailText'))->first();
            $template = Template::where('file_name',$request->input('templateText'))->first();
            $campaign = Campaign::where('id',$request->input('campaignText'))->first();

            if(empty($fromEmail) || empty($template) || empty($campaign)) {
                return redirect()->route('generatePhish');
            }

            $cryptor = new Cryptor();
            $password = $cryptor->decrypt($fromEmail->password);

            putenv("MAIL_USERNAME=$fromEmail->email_address");
            putenv("MAIL_NAME=$fromEmail->name");
            putenv("MAIL_PASSWORD=$password");

            $templateClass = 'MailTemplates\\' . $template->mailable;
            $sendingChoice = $request->input('sendingChoiceRadio');

            if($sendingChoice === 'user') {
                self::sendToUser(intval($request->input('userIdText')),$templateClass,$campaign,$request->input('companyText'));

            } else {
                self::sendToGroup(intval($request->input('groupIdText')),$templateClass,$campaign,$request->input('companyText'));
            }
            return redirect()->route('generatePhish');

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * sendToUser
     * Sends and logs emails sent to a user.
     *
     * @param   int       $userId
     * @param   string    $templateClass
     * @param   Campaign  $campaign
     * @param   string    $company
     * @return  Sent_Mail
     */
    private static function sendToUser($userId,$templateClass,$campaign,$company) {
        try {
            $user = Mailing_List_User::where('id',$userId)->first();
            if(empty($user)) {
                ErrorLogging::logError(new Exception("MLU not found."));
                return abort('500');
            }

            $name = $user->first_name . ' ' . $user->last_name;
            Mail::to($user->email,$name)
                ->send(new $templateClass($user,$campaign,$company));
            return self::logSentEmail($user,$campaign);

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * sendToGroup
     * Sends and logs emails sent to a group.
     *
     * @param   int       $groupId
     * @param   string    $templateClass
     * @param   Campaign  $campaign
     * @param   string    $company
     * @return  bool
     */
    private static function sendToGroup($groupId,$templateClass,$campaign,$company) {
        try {
            $group = Mailing_List_Groups::where('id',$groupId)->first();
            if(empty($group)) {
                ErrorLogging::logError(new Exception("Mailing List Group not found."));
                return abort('500');
            }

            $bridge = Mailing_List_Users_Groups_Bridge::where('group_id',$group->id)->get();

            foreach($bridge as $pair) {
                $sent = self::sendToUser($pair->user_id,$templateClass,$campaign,$company);
                if(!($sent instanceof Sent_Mail)) {
                    return abort('500');
                }
            }

            return true;

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * sendNewAccountEmail
     * Sends email to user when they're account gets created.
     *
     * @param   User            $user
     * @param   string          $password
     * @return  bool
     */
    public static function sendNewAccountEmail(User $user, $password) {
        try {
            if(Auth::adminCheck()) {

                $name = $user->first_name . ' ' . $user->last_name;
                Mail::to($user->email,$name)
                    ->send(new MailTemplates\NewUser($user,$password));
                return true;
            }
            return false;

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * sendTwoFactorEmail
     * Sends email to user containing their two factor code.
     *
     * @param   User            $user
     * @param   string          $code
     * @return  bool
     */
    public static function sendTwoFactorEmail(User $user, $code) {
        try {
            $name = $user->first_name . ' ' . $user->last_name;
            Mail::to($user->email,$name)
                ->send(new MailTemplates\TwoFactorCode($user,$code));
            return true;

        } catch(Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * logSentEmail
     * Logs to sent_email table info about this email and associated recipient.
     *
     * @param   Mailing_List_User           $user
     * @param   Campaign                    $campaign
     * @return  Sent_Mail
     */
    private static function logSentEmail(Mailing_List_User $user, Campaign $campaign) {
        return Sent_Mail::create(
            ['user_id'=>$user->id,
                'campaign_id'=>$campaign->id,
                'timestamp'=>Carbon::now()]
        );
    }
}
