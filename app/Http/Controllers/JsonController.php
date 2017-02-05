<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
use App\Models\Mailing_List_User;
use App\Models\MLU_Departments;
use App\Models\Template;
use App\Models\Campaign;

class JsonController extends Controller
{
    /**
     * postCampaignsJson
     * Queries all campaigns and returns a JSON string with the objects.
     *
     * @return  \Illuminate\Http\RedirectResponse | string
     */
    public static function postCampaignsJson() {
        if(Auth::check()) {
            $json = Campaign::all();
            return "{\"campaigns\":$json}";
        }
        return redirect()->route('e401');
    }

    /**
     * postTemplatesJson
     * Queries all templates and returns a JSON string with the objects.
     *
     * @return  \Illuminate\Http\RedirectResponse | string
     */
    public static function postTemplatesJson() {
        if(Auth::check()) {
            $json = Template::all();
            return "{\"templates\":$json}";
        }
        return redirect()->route('e401');
    }

    /**
     * postMLUJson
     * Queries all mailing list users and returns a JSON string with the objects.
     *
     * @return  \Illuminate\Http\RedirectResponse | string
     */
    public static function postMLUJson() {
        if(Auth::check()) {
            $json = Mailing_List_User::all();
            return "{\"mlu\":$json}";
        }
        return redirect()->route('e401');
    }

    /**
     * postMLUDJson
     * Queries all mailing list departments and returns a JSON string with the objects.
     *
     * @return  \Illuminate\Http\RedirectResponse | string
     */
    public static function postMLUDJson() {
        if(Auth::check()) {
            $json = MLU_Departments::all();
            return "{\"mlud\":$json}";
        }
        return redirect()->route('e401');
    }
}
