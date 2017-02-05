<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/27/2016
 * Time: 11:26 AM
 */

namespace App\Models;


use App\Http\Traits\CompositeKeyTrait;
use Illuminate\Database\Eloquent\Model;

class Mailing_List_User_Department_Bridge extends Model
{
    protected $table = 'mailing_list_users_departments_bridge';

    protected $primaryKey = ['UserId','DepartmentId'];
    public $incrementing = false;

    public $timestamps = false;

    use CompositeKeyTrait;

    protected $fillable =
        ['UserId',
            'DepartmentId'
        ];
}