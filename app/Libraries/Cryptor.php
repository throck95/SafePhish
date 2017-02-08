<?php
/**
 * Created by PhpStorm.
 * User: tyler
 * Date: 2/7/2017
 * Time: 2:04 PM
 */

namespace App\Libraries;


class Cryptor
{
    protected $method = 'AES-256-CTR';
    private $key;

    protected function iv_bytes()
    {
        return openssl_cipher_iv_length($this->method);
    }

    public function __construct($key = false, $method = false)
    {
        if(!$key) {
            // if you don't supply your own key, this will be the default
            $key = file_get_contents('../../SafePhish_Cryptor_Secret_Key.txt');
        }
        if(ctype_print($key)) {
            // convert key to binary format
            $this->key = openssl_digest($key, 'SHA256', true);
        } else {
            $this->key = $key;
        }
        if($method) {
            if(in_array($method, openssl_get_cipher_methods())) {
                $this->method = $method;
            } else {
                die(__METHOD__ . ": unrecognised encryption method: {$method}");
            }
        }
    }

    public function encrypt($data)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_bytes());
        $encrypted_string = bin2hex($iv) . openssl_encrypt($data, $this->method, $this->key, 0, $iv);
        return $encrypted_string;
    }

    // decrypt encrypted string
    public function decrypt($data)
    {
        $iv_strlen = 2 * $this->iv_bytes();
        if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
            list(, $iv, $crypted_string) = $regs;
            $decrypted_string = openssl_decrypt($crypted_string, $this->method, $this->key, 0, hex2bin($iv));
            return $decrypted_string;
        } else {
            return false;
        }
    }
}