<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/3/2016
 * Time: 3:29 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Default_Settings extends Model
{
    protected $table = 'default_emailsettings';

    protected $fillable = ['DFT_UserId',
        'DFT_MailServer',
        'DFT_MailPort',
        'DFT_Username',
        'DFT_CompanyName'];
}