<?php
/**
 * Created by PhpStorm.
 * User: Tyler Throckmorton
 * Date: 9/15/2016
 * Time: 3:05 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MLU_Departments extends Model
{
    protected $table = 'mailing_list_departments';

    public $timestamps = false;

    protected $fillable =
        ['MLD_Department'];
}