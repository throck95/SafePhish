<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/20/2016
 * Time: 12:39 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['PRJ_Name',
        'PRJ_Description',
        'PRJ_ComplexityType',
        'PRJ_TargetType',
        'PRJ_Assignee',
        'PRJ_Status'];
}