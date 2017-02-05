<?php
/**
 * Created by PhpStorm.
 * User: Tyler Throckmorton
 * Date: 9/6/2016
 * Time: 1:11 AM
 */

namespace App\Http\Controllers;


class ErrorController extends Controller
{
    public static function e401() {
        return view("errors.401");
    }

    public static function e404() {
        return view("errors.404");
    }

    public static function e500() {
        return view("errors.500");
    }
}