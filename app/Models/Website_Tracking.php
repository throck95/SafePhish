<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website_Tracking extends Model
{
    protected $table = 'website_tracking';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['ip_address',
        'host',
        'browser_agent',
        'req_path',
        'user_id',
        'campaign_id',
        'timestamp'];
}