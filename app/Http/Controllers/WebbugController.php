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
     * @param 	string		$id		Contains UniqueURLId that references specific user and specific project ID
     */
    public function webbugParse($id) {
        $urlId = substr($id,0,15);
        $projectId = substr($id,15);
        $recipient = Mailing_List_User::where('MGL_UniqueURLId',$urlId)->first();
        $userId = $recipient->MGL_Id;
        if(strpos($_SERVER['REQUEST_URI'],'email') !== false) {
            $this->webbugExecutionEmail($userId,$projectId);
        } else {
            $this->webbugExecutionWebsite($userId,$projectId);
        }
    }

    /**
     * webbugExecutionEmail
     * Email specific execution of the webbug tracker.
     *
     * @param 	int         $userId			    User ID of user passed
     * @param 	string		$projectId			Project ID to create a filter choice in the results
     */
    private function webbugExecutionEmail($userId, $projectId) {
        $tracking = Email_Tracking::create(
            ['EML_Ip'=>$_SERVER['REMOTE_ADDR'],
                'EML_Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'EML_UserId'=>$userId,
                'EML_ProjectId'=>$projectId,
                'EML_Timestamp'=>Carbon::now()]
        );
    }

    /**
     * webbugExecutionWebsite
     * Website specific execution of the webbug tracker.
     *
     * @param 	int         $userId			    User ID of user passed
     * @param 	string		$projectId			Project ID to create a filter choice in the results
     */
    private function webbugExecutionWebsite($userId,$projectId) {
        $tracking = Website_Tracking::create(
            ['WBS_Ip'=>$_SERVER['REMOTE_ADDR'],
                'WBS_Host'=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                'WBS_BrowserAgent'=>$_SERVER['HTTP_USER_AGENT'],
                'WBS_ReqPath'=>$_SERVER['REQUEST_URI'],
                'WBS_UserId'=>$userId,
                'WBS_ProjectId'=>$projectId,
                'WBS_Timestamp'=>Carbon::now()]
        );
    }
}
