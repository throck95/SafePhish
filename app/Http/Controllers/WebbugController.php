<?php

namespace App\Http\Controllers;

use App\Models\Email_Tracking;
use App\Models\Website_Tracking;
use App\Models\Mailing_List_User;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WebbugController extends Controller
{
    /**
     * webbugParse
     * Handles when webbugs get called. If request URI contains the word 'email', executes email webbug otherwise executes website webbug
     *
     * @param 	string		$id		Contains UniqueURLId that references specific user and specific campaign ID
     */
    public function webbugParse($id) {
        $urlId = substr($id,0,15);
        $campaignId = substr($id,15);
        $recipient = Mailing_List_User::where('UniqueURLId',$urlId)->first();
        $userId = $recipient->MGL_Id;
        if(strpos($_SERVER['REQUEST_URI'],'email') !== false) {
            $this->webbugExecutionEmail($userId,$campaignId);
        } else {
            $this->webbugExecutionWebsite($userId,$campaignId);
        }
    }

    /**
     * webbugExecutionEmail
     * Email specific execution of the webbug tracker.
     *
     * @param 	int         $userId			    User ID of user passed
     * @param 	string		$campaignId			Campaign ID to create a filter choice in the results
     */
    private function webbugExecutionEmail($userId, $campaignId) {
        $tracking = Email_Tracking::create(
            ['Ip'=>$_SERVER['REMOTE_ADDR'],
                'Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'UserId'=>$userId,
                'CampaignId'=>$campaignId,
                'Timestamp'=>Carbon::now()]
        );
    }

    /**
     * webbugExecutionWebsite
     * Website specific execution of the webbug tracker.
     *
     * @param 	int         $userId			    User ID of user passed
     * @param 	string		$campaignId			Campaign ID to create a filter choice in the results
     */
    private function webbugExecutionWebsite($userId,$campaignId) {
        $tracking = Website_Tracking::create(
            ['Ip'=>$_SERVER['REMOTE_ADDR'],
                'Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'BrowserAgent'=>$_SERVER['HTTP_USER_AGENT'],
                'ReqPath'=>$_SERVER['REQUEST_URI'],
                'UserId'=>$userId,
                'CampaignId'=>$campaignId,
                'Timestamp'=>Carbon::now()]
        );
    }
}
