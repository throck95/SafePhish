<?php

namespace App\Http\Controllers;

use App\Models\Email_Tracking;
use App\Models\User;
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
    private function webbugParse($id) {
        $urlId = substr($id,0,12);
        $campaignId = substr($id,13);
        $user = Mailing_List_User::where('UniqueURLId',$urlId)->first();
        if(strpos($_SERVER['REQUEST_URI'],'email') !== false) {
            $this->webbugExecutionEmail($user,$campaignId);
        } else {
            $this->webbugExecutionWebsite($user,$campaignId);
        }
    }

    /**
     * webbugExecutionEmail
     * Email specific execution of the webbug tracker.
     *
     * @param 	User        $user
     * @param 	string		$campaignId			Campaign ID to create a filter choice in the results
     */
    private function webbugExecutionEmail($user, $campaignId) {
        Email_Tracking::create(
            ['Ip'=>$_SERVER['REMOTE_ADDR'],
                'Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'UserId'=>$user->Id,
                'CampaignId'=>$campaignId,
                'Timestamp'=>Carbon::now()]
        );
    }

    /**
     * webbugExecutionWebsite
     * Website specific execution of the webbug tracker.
     *
     * @param 	User        $user
     * @param 	string		$campaignId			Campaign ID to create a filter choice in the results
     */
    private function webbugExecutionWebsite($user,$campaignId) {
        Website_Tracking::create(
            ['Ip'=>$_SERVER['REMOTE_ADDR'],
                'Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'BrowserAgent'=>$_SERVER['HTTP_USER_AGENT'],
                'ReqPath'=>$_SERVER['REQUEST_URI'],
                'UserId'=>$user->Id,
                'CampaignId'=>$campaignId,
                'Timestamp'=>Carbon::now()]
        );
    }

    public function createAndReturnWebbug($Id) {
        $this->webbugParse($Id);
        header('Content-Type: image/gif');
        return base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
    }
}
