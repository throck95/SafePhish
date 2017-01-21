<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;


    protected $table = 'users';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        ['Username',
        'Email',
        'FirstName',
        'LastName',
        'MiddleInitial',
        'Password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array

    protected $hidden = [
        'password', 'remember_token',
    ];*/
}