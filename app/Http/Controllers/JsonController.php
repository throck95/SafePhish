<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
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
}
