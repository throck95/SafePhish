<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\ErrorLogging;
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
        try {
            if(Auth::check()) {
                $json = Campaign::queryCampaigns();
                return "{\"campaigns\":$json}";
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * postTemplatesJson
     * Queries all templates and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postTemplatesJson() {
        try {
            if(Auth::check()) {
                $json = Template::all();
                return "{\"templates\":$json}";
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * postMLUJson
     * Queries all mailing list users and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postMLUJson() {
        try {
            if(Auth::check()) {
                $json = Mailing_List_User::queryMLU();
                return "{\"mlu\":$json}";
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * postGroupsJson
     * Queries all mailing list groups and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postGroupsJson() {
        try {
            if(Auth::check()) {
                $json = Mailing_List_Groups::all();
                return "{\"groups\":$json}";
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }

    /**
     * postUsersJson
     * Queries all users and returns a JSON string with the objects.
     *
     * @return  string
     */
    public static function postUsersJson() {
        try {
            if(Auth::adminCheck()) {
                $json = User::queryUsers();
                return "{\"users\":$json}";
            }
            return abort('401');

        } catch(\Exception $e) {
            ErrorLogging::logError($e);
            return abort('500');
        }
    }
}
