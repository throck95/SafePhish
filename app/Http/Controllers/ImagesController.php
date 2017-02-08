<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TemplateConfiguration;
use App\EmailConfiguration;
use App\Email;
use App\Http\Controllers\AuthController as Auth;

use App\Models\Campaign;
use App\Models\Sent_Mail;
use App\Models\Mailing_List_User;

use App\Exceptions\ConfigurationException;
use App\Exceptions\EmailException;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{
    public function displayBlackFridayImage() {
        $path = 'images/emails/black_friday.png';
        $file = fopen($path,'rb');

        header('Content-Type: image/png');
        header('Content-Length: ' . filesize($path));

        fpassthru($file);
    }
}
