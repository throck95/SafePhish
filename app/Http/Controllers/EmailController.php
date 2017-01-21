<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TemplateConfiguration;
use App\EmailConfiguration;
use App\Email;
use App\Http\Controllers\AuthController as Auth;

use App\Models\Campaign;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;

use App\Exceptions\ConfigurationException;
use App\Exceptions\EmailException;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    /**
     * sendEmail
     * Function mapped to Laravel route. Defines variable arrays and calls Email Class executeEmail.
     *
     * @param    Request $request Request object passed via AJAX from client.
     */
    public static function sendEmail(Request $request)
    {
        if(Auth::check()) {
            try {
                $templateConfig = new TemplateConfiguration(
                    array(
                        'templateName' => $request->input('emailTemplate'),
                        'companyName' => $request->input('companyText'),
                        'campaignName' => $request->input('campaignData')['campaignName'],
                        'campaignId' => intval($request->input('campaignData')['campaignId'])
                    )
                );
                $periodInWeeks = 4;
                $emailConfig = new EmailConfiguration(
                    array(
                        'host' => $request->input('mailServerText'),
                        'port' => $request->input('mailPortText'),
                        'authUsername' => $request->input('fromEmailText'),
                        'authPassword' => $request->input('fromPass'),
                        'fromEmail' => $request->input('fromEmailText'),
                        'subject' => $request->input('subject')
                    )
                );
                $recipients = self::validateMailingList($periodInWeeks);

                Email::executeEmail($emailConfig, $templateConfig, $recipients);
            } catch (ConfigurationException $ce) {
                //write to log file
            } catch (EmailException $ee) {
                //write to log file
                //track emails unsent and include in log?
            }
        }
    }

    /**
     * retrieveCampaigns
     * Helper function to grab the 3 most recent campaigns for a user, then grab the campaign object of each campaign.
     *
     * @param   int             $id         Mailing_List_User ID of the requested user.
     * @return  array
     */
    private static function retrieveCampaigns($id) {
        $join = DB::table('sent_email')
            ->leftJoin('campaigns','sent_email.CampaignId','=','campaigns.Id')
            ->where('sent_email.UserId',$id)
            ->orderBy('sent_email.Timestamp','desc')
            ->limit(3)
            ->get();
        $campaigns = array();
        foreach($join as $item) {
            $campaigns[] = $item;
        }
        return $campaigns;
    }

    /**
     * validateMailingList
     * Validates all the mailing_list recipients. Returns only those that will receive the email.
     *
     * @param   int             $periodInWeeks          Number of weeks back to check for most recent email.
     * @return  array
     */
    private static function validateMailingList($periodInWeeks) {
        $users = Mailing_List_User::all();
        $mailingList = array();
        $date = date('Y-m-d h:i:s',strtotime("-$periodInWeeks weeks"));
        foreach($users as $user) {
            $campaigns = self::retrieveCampaigns($user->Id);
            if($campaigns[0]->updated_at <= $date) {
                $mailingList[] = $user;
            }
        }
        return $mailingList;
    }
}
