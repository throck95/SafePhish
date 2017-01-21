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

    protected $primaryKey = 'UserId';

    protected $fillable = ['UserId',
        'MailServer',
        'MailPort',
        'Username',
        'CompanyName'];
}