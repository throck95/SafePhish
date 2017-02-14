<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
use App\Models\Mailing_List_Groups;
use App\Models\Mailing_List_User;
use App\Models\Template;
use App\Models\Campaign;
use App\Models\User;

class JsonController extends Controller
{
    /**
     * postCampaignsJson
     * Queries all campaigns and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postCampaignsJson() {
        if(Auth::check()) {
            $json = Campaign::all();
            return "{\"campaigns\":$json}";
        }
        return abort('401');
    }

    /**
     * postTemplatesJson
     * Queries all templates and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postTemplatesJson() {
        if(Auth::check()) {
            $json = Template::all();
            return "{\"templates\":$json}";
        }
        return abort('401');
    }

    /**
     * postMLUJson
     * Queries all mailing list users and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postMLUJson() {
        if(Auth::check()) {
            $json = Mailing_List_User::all();
            return "{\"mlu\":$json}";
        }
        return abort('401');
    }

    /**
     * postGroupsJson
     * Queries all mailing list groups and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postGroupsJson() {
        if(Auth::check()) {
            $json = Mailing_List_Groups::all();
            return "{\"groups\":$json}";
        }
        return abort('401');
    }

    /**
     * postUsersJson
     * Queries all users and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postUsersJson() {
        if(Auth::adminCheck()) {
            $json = User::queryUsers();
            return "{\"users\":$json}";
        }
        return abort('401');
    }
}
