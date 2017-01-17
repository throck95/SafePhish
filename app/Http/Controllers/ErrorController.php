<?php
/**
 * Created by PhpStorm.
 * User: Tyler Throckmorton
 * Date: 9/6/2016
 * Time: 1:11 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TemplateConfiguration;
use App\EmailConfiguration;
use App\Email;
use App\Http\Controllers\AuthController as Auth;

use App\Models\Project;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;

use App\Exceptions\ConfigurationException;
use App\Exceptions\EmailException;
use Illuminate\Support\Facades\DB;

class ErrorController extends Controller
{
    public static function e401() {
        return view("errors.401");
    }
}