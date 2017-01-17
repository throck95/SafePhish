<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/3/2016
 * Time: 4:25 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table = 'reports';

    public $timestamps = false;

    protected $fillable = ['RPT_EmailSubject',
        'RPT_UserEmail',
        'RPT_OriginalFrom',
        'RPT_CreateDate'];
}