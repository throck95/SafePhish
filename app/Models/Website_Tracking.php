<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/1/2016
 * Time: 11:20 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website_Tracking extends Model
{
    protected $table = 'website_tracking';

    public $timestamps = false;

    protected $fillable = ['WBS_Ip',
        'WBS_Host',
        'WBS_BrowserAgent',
        'WBS_ReqPath',
        'WBS_UserId',
        'WBS_ProjectId',
        'WBS_Timestamp'];
}