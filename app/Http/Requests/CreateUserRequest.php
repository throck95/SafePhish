<?php

namespace App\Http\Requests;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class CreateUserRequest extends Request
{
    public function authorize() {
        return AuthController::adminCheck();
    }

    public function rules() {
        return [
            'emailText' => 'bail|required|email|unique:users,email',
            'confirmEmailText' => 'bail|same:emailText',
            'firstNameText' => 'bail|required',
            'lastNameText' => 'bail|required',
            'middleInitialText' => 'bail|max:1',
            'permissionsSelect' => 'bail|required'
        ];
    }
}