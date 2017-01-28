<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/27/2016
 * Time: 11:26 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mailing_List_User extends Model
{
    protected $table = 'mailing_list';

    protected $primaryKey = 'Id';

    protected $fillable =
        ['Email',
            'FirstName',
            'LastName',
            'Department',
            'UniqueURLId'];
}