<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\Mailing_List_User;

class LinksController extends Controller
{
    public static function disclosePhishingEmail($id) {
        $tipsVideoUrl = getenv('TIPS_VIDEO_URL');
        $urlId = substr($id,0,intval(getenv('DEFAULT_LENGTH_IDS')));
        $campaignId = substr($id,intval(getenv('DEFAULT_LENGTH_IDS'))+1);
        $user = Mailing_List_User::where('unique_url_id',$urlId)->first();

        if(empty($user)) {
            abort('500');
        }

        $campaign = Campaign::where('id',$campaignId)->first();

        if(empty($campaign)) {
            abort('500');
        }

        $company = Company::where('id',$user->company_id)->first();

        if(empty($company)) {
            abort('500');
        }

        WebbugController::webbugExecutionWebsite($user,$campaign);

        $variables = array('tipsVideoUrl'=>$tipsVideoUrl,'company'=>$company->name,'user'=>$user,'campaign'=>$campaign);
        return view('links.disclosure')->with($variables);
    }
}