<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $table = 'sessions';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id',
        'ip_address',
        'two_factor_id',
        'authenticated'
    ];
}