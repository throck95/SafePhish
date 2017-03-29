<?php

namespace App\Http\Controllers;

use App\Libraries\ErrorLogging;
use App\Models\Campaign;
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
     * Handles when webbugs get called via emails.
     *
     * @param 	string		$id		Contains UniqueURLId that references specific user and specific campaign ID
     */
    private function webbugParse($id) {
        try {
            $urlId = substr($id,0,12);
            $campaignId = substr($id,13);
            $user = Mailing_List_User::where('unique_url_id',$urlId)->first();
            $campaign = Campaign::where('id',$campaignId)->first();

            if(empty($user) || empty($campaign)) {
                return;
            }

            Email_Tracking::create(
                ['ip_address'=>$_SERVER['REMOTE_ADDR'],
                    'host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                    'user_id'=>$user->id,
                    'campaign_id'=>$campaign->id,
                    'timestamp'=>Carbon::now()]
            );

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
        }
    }

    /**
     * webbugExecutionWebsite
     * Website specific execution of the webbug tracker.
     *
     * @param 	Mailing_List_User       $user
     * @param 	Campaign		        $campaign
     */
    public static function webbugExecutionWebsite($user,$campaign) {
        Website_Tracking::create(
            ['ip_address'=>$_SERVER['REMOTE_ADDR'],
                'host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'browser_agent'=>$_SERVER['HTTP_USER_AGENT'],
                'req_path'=>$_SERVER['REQUEST_URI'],
                'user_id'=>$user->id,
                'campaign_id'=>$campaign->id,
                'timestamp'=>Carbon::now()]
        );
    }

    public function createAndReturnWebbug($id) {
        $this->webbugParse($id);
        header('Content-Type: image/png');
        return base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
    }
}
