<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Permissions extends Model
{
    protected $table = 'user_permissions';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['permission_type'];
}