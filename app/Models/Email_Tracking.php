<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email_Tracking extends Model
{
    protected $table = 'email_tracking';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['ip_address',
        'host',
        'user_id',
        'campaign_id',
        'timestamp'];
}