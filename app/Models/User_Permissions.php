<?php
/**
 * Created by PhpStorm.
 * User: tyler
 * Date: 1/23/2017
 * Time: 10:22 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Permissions extends Model
{
    protected $table = 'user_permissions';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = ['PermissionType'];
}