<?php

namespace App\Models;

use App\Http\Traits\CompositeKeyTrait;
use Illuminate\Database\Eloquent\Model;

class Mailing_List_Users_Groups_Bridge extends Model
{
    protected $table = 'mailing_list_users_groups_bridge';

    protected $primaryKey = ['mailing_list_user_id','department_id'];
    public $incrementing = false;

    public $timestamps = false;

    use CompositeKeyTrait;

    protected $fillable =
        ['mailing_list_user_id',
            'department_id'
        ];
}