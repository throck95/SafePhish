<?php

namespace App\Http\Controllers;

use App\Libraries\ErrorLogging;
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
        try {
            $urlId = substr($id,0,12);
            $campaignId = substr($id,13);
            $user = Mailing_List_User::where('unique_url_id',$urlId)->first();
            if(strpos($_SERVER['REQUEST_URI'],'email') !== false) {
                $this->webbugExecutionEmail($user, $campaignId);
            } else {
                $this->webbugExecutionWebsite($user,$campaignId);
            }

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
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
            ['ip_address'=>$_SERVER['REMOTE_ADDR'],
                'host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'user_id'=>$user->id,
                'campaign_id'=>$campaignId,
                'timestamp'=>Carbon::now()]
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
            ['ip_address'=>$_SERVER['REMOTE_ADDR'],
                'host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'browser_agent'=>$_SERVER['HTTP_USER_AGENT'],
                'req_path'=>$_SERVER['REQUEST_URI'],
                'user_id'=>$user->id,
                'campaign_id'=>$campaignId,
                'timestamp'=>Carbon::now()]
        );
    }

    public function createAndReturnWebbug($Id) {
        $this->webbugParse($Id);
        header('Content-Type: image/png');
        return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
    }
}
