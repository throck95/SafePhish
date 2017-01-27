<?php
/**
 * Created by PhpStorm.
 * User: tyler
 * Date: 1/23/2017
 * Time: 10:22 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Two_Factor extends Model
{
    protected $table = 'two_factor_codes';

    protected $primaryKey = 'ID';

    protected $fillable = ['UserID',
        'Ip',
        'Code'];
}