<?php

namespace App\Libraries;

use Doctrine\Instantiator\Exception\InvalidArgumentException;

class RandomObjectGeneration
{
    const KEYSPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const PASSWORD_KEYSPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&';

    /**
     * random_str
     * Generates a random string.
     *
     * @param   int                         $length         Length of string to be returned
     * @param   bool                        $passwordFlag   Boolean flag identifying whether string will be a password
     * @param   string                      $keyspace       Allowed characters to be used in string
     * @throws  InvalidArgumentException
     * @return  string
     */
    public static function random_str($length, $passwordFlag = false, $keyspace = RandomObjectGeneration::KEYSPACE)
    {
        if($passwordFlag) {
            $keyspace = RandomObjectGeneration::PASSWORD_KEYSPACE;
        }
        if(empty($length) || !is_int($length) || $length < 0) {
            $message = 'Random String Generation: Length is Invalid. Length must be a positive integer. Value Provided: ' .
                var_export($length);
            throw new InvalidArgumentException($message);
        }
        if(empty($keyspace) || !is_string($keyspace)) {
            $message = 'Random String Generation: Invalid Keyspace';
            throw new InvalidArgumentException($message);
        }
        $str = '';
        $max = mb_strlen($keyspace) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}