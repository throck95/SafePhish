<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sent_Mail extends Model
{
    protected $table = 'sent_email';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['mailing_list_user_id',
        'campaign_id',
        'timestamp'];
}