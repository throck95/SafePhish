<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/20/2016
 * Time: 12:39 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $primaryKey = 'Id';

    protected $fillable = ['Name',
        'Description',
        'Assignee',
        'Status'];
}