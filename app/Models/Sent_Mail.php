<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/29/2016
 * Time: 9:50 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Sent_Mail extends Model
{
    protected $table = 'sent_email';

    public $timestamps = false;

    protected $fillable = ['SML_UserId',
        'SML_ProjectId',
        'SML_Timestamp'];
}