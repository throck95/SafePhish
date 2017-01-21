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

    protected $primaryKey = 'Id';

    protected $fillable = ['Ip',
        'Host',
        'BrowserAgent',
        'ReqPath',
        'UserId',
        'CampaignId',
        'Timestamp'];
}