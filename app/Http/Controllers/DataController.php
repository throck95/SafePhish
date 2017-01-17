<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Models\Email_Tracking;
use App\Models\Website_Tracking;
use App\Models\Reports;

class DataController extends Controller
{
    /**
     * postWebsiteJson
     * Posts data queried from website_tracking table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postWebsiteJson() {
        if(Auth::check()) {
            $json = Website_Tracking::all();
            return $json;
        }
        return redirect()->route('e401');
    }

    /**
     * postEmailJson
     * Posts data queried from email_tracking table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postEmailJson() {
        if(Auth::check()) {
            $json = Email_Tracking::all();
            return $json;
        }
        return redirect()->route('e401');
    }

    /**
     * postReportsJson
     * Posts data queried from reports table. Requires authenticated user to execute data retrieval.
     *
     * @return  array|\Illuminate\Http\RedirectResponse
     */
    public static function postReportsJson() {
        if(Auth::check()) {
            $json = Reports::all();
            return $json;
        }
        return redirect()->route('e401');
    }
}
