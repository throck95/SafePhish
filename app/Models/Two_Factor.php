<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Two_Factor extends Model
{
    protected $table = 'two_factor_codes';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id',
        'ip_address',
        'code'];
}