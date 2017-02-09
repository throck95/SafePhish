<?php

namespace App\Http\Controllers;

use App\Models\Email_Tracking;
use App\Models\Website_Tracking;
use App\Http\Controllers\AuthController As Auth;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public static function disclosePhishingEmail() {
        return view('links.disclosure');
    }
}