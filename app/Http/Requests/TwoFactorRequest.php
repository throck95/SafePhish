<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class TwoFactorRequest extends Request
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'codeText' => 'bail|required|digits:6'
        ];
    }
}