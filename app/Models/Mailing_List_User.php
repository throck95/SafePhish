<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/27/2016
 * Time: 11:26 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mailing_List_User extends Model
{
    protected $table = 'mailing_list';

    protected $fillable =
        ['MGL_Username',
            'MGL_Email',
            'MGL_FirstName',
            'MGL_LastName',
            'MGL_Department',
            'MGL_UniqueURLId'];
}