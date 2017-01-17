<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/14/2016
 * Time: 3:33 PM
 */

namespace App\Exceptions;

use League\Flysystem\Exception;


class ConfigurationException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message,$code,$previous);
    }
}