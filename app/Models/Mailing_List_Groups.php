<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing_List_Groups extends Model
{
    protected $table = 'mailing_list_groups';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable =
        ['name'];
}