<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/1/2016
 * Time: 11:20 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email_Tracking extends Model
{
    protected $table = 'email_tracking';

    public $timestamps = false;

    protected $fillable = ['EML_Ip',
        'EML_Host',
        'EML_UserId',
        'EML_ProjectId',
        'EML_Timestamp'];
}