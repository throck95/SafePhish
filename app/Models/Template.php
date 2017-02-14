<?php

namespace App\Models;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use League\Flysystem\FileExistsException;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'templates';

    protected $fillable = ['email_type',
        'file_name',
        'public_name',
        'mailable'
    ];

    protected $primaryKey = 'file_name';

    public $incrementing = false;
}