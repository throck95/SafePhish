<?php

namespace App\Http\Controllers;

use App\Libraries\Cryptor;
use App\Mail\NewUser;
use App\Mail\TwoFactorCode;
use App\Models\Campaign_Email_Addresses;
use App\Models\MLU_Departments;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\Campaign;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * sendEmail
     * Function mapped to Laravel route. Defines variable arrays and calls Email Class executeEmail.
     *
     * @param    Request $request Request object passed via AJAX from client.
     */
    public static function sendPhishingEmail(Request $request)
    {
        if(Auth::check()) {
            $fromEmail = Campaign_Email_Addresses::where('Email_Address',$request->input('fromEmailText'))->first();
            $template = Template::where('FileName',$request->input('templateText'))->first();
            $campaign = Campaign::where('Id',$request->input('campaignText'))->first();
            if(!empty($fromEmail) && !empty($template) && !empty($campaign)) {
                putenv("MAIL_USERNAME=$fromEmail->Email");
                putenv("MAIL_NAME=$fromEmail->Name");
                $cryptor = new Cryptor();
                $password = $cryptor->decrypt($fromEmail->Password);
                putenv("MAIL_PASSWORD=$password");
                $templateClass = "\\App\\Mail\\$template->Mailable";
                $sendingChoice = $request->input('sendingChoiceRadio');
                if($sendingChoice == 'user') {
                    $user = Mailing_List_User::where('Id',$request->input('userIdText'))->first();
                    if(!empty($user)) {
                        Mail::to($user->Email,$user->FirstName . ' ' . $user->LastName)
                            ->send(new $templateClass($user,$campaign,$request->input('companyText')));
                        self::logSentEmail($user,$campaign);
                    }
                } else {
                    $group = MLU_Departments::where('Id',$request->input('groupIdText'))->first();
                    if(!empty($group)) {
                        foreach($group as $userId) {
                            $user = Mailing_List_User::where('Id',$userId)->first();
                            if(!empty($user)) {
                                Mail::to($user->Email,$user->FirstName . ' ' . $user->LastName)
                                    ->send(new $templateClass($user,$campaign,$request->input('companyText')));
                                self::logSentEmail($user,$campaign);
                            }
                        }
                    }
                }
            }
        }
    }

    public static function sendNewAccountEmail(User $user, $password) {
        if(Auth::adminCheck()) {
            Mail::to($user->Email,$user->FirstName . ' ' . $user->LastName)
                ->send(new NewUser($user,$password));
        }
    }

    public static function sendTwoFactorEmail(User $user, $code) {
        Mail::to($user->Email,$user->FirstName . ' ' . $user->LastName)
            ->send(new TwoFactorCode($user,$code));
    }

    /**
     * logSentEmail
     * Logs to sent_email table info about this email and associated recipient.
     *
     * @param   Mailing_List_User           $user
     */
    private static function logSentEmail(Mailing_List_User $user, Campaign $campaign) {
        Sent_Mail::create(
            ['UserId'=>$user->Id,
                'CampaignId'=>$campaign->Id,
                'Timestamp'=>Carbon::now()]
        );
    }
}
