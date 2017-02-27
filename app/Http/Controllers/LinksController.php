<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Mailing_List_User;

class LinksController extends Controller
{
    public static function disclosePhishingEmail($id) {
        $tipsVideoUrl = getenv('TIPS_VIDEO_URL');
        $urlId = substr($id,0,intval(getenv('DEFAULT_LENGTH_IDS')));
        $mailing_list_user = Mailing_List_User::where('unique_url_id',$urlId)->first();

        if(empty($mailing_list_user)) {
            abort('500');
        }

        $company = Company::where('id',$mailing_list_user->company_id)->first();

        if(empty($company)) {
            abort('500');
        }

        $variables = array('tipsVideoUrl'=>$tipsVideoUrl,'company'=>$company->name);
        return view('links.disclosure')->with($variables);
    }
}