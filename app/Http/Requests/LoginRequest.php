<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class LoginRequest extends Request
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'emailText' => 'bail|required|email',
            'passwordText' => 'bail|required'
        ];
    }
}