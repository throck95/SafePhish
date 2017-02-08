<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/4/2016
 * Time: 11:04 AM
 */

namespace App\Models;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use League\Flysystem\FileExistsException;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = ['EmailType',
        'FileName',
        'PublicName',
        'Mailable'
    ];

    protected $primaryKey = 'FileName';

    public $incrementing = false;
}