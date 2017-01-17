<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 8/1/2016
 * Time: 8:55 AM
 */

namespace App\Libraries;

use Doctrine\Instantiator\Exception\InvalidArgumentException;


class RandomObjectGeneration
{
    /**
     * const::KEYSPACE
     * Alphanumeric Keyspace for string randomization.
     */
    const KEYSPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * random_str
     * Generates a random string.
     *
     * @param   int                         $length         Length of string to be returned
     * @param   string                      $keyspace       Allowed characters to be used in string
     * @throws  InvalidArgumentException
     * @return  string
     */
    public static function random_str($length, $keyspace = RandomObjectGeneration::KEYSPACE)
    {
        $str = '';
        if(is_null($length) || !is_int($length) || (is_int($length) && $length < 0)) {
            $str .= 'random_str: Length is invalid. Length must be a positive integer. Value Provided: ' .
                var_export($length) . PHP_EOL;
        }
        if(strlen($keyspace) == 0) {
            $str .= 'random_str: Keyspace cannot be of length 0. Length must be a positive integer.' . PHP_EOL;
        }
        if(!empty($str)) {
            throw new InvalidArgumentException($str);
        }
        $max = mb_strlen($keyspace) - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}