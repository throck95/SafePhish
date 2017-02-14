<?php

namespace App\Models;

use App\Libraries\Cryptor;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Driver\Exception\DuplicateKeyException;

class Campaign_Email_Addresses extends Model
{
    protected $table = 'campaign_email_addresses';

    protected $primaryKey = 'email_address';

    public $incrementing = false;

    protected $fillable = ['email_address',
        'name',
        'password'];

    public static function insertEmail($email, $name, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::where('email_address',$email)->first();
        if(count($query)) {
            throw new DuplicateKeyException("Email Address already exists.");
        }
        return self::create([
            'email_address'=>$email,
            'name'=>$name,
            'password'=>$encrypted
        ]);
    }

    public static function updateEmail($email, $name, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::query();
        $query->where('email_address',$email);
        $query->update(['password'=>$encrypted,'name'=>$name]);
        return $query->get();
    }

    public static function decryptPassword($email) {
        $cryptor = new Cryptor();
        $password = self::where('email_address',$email)->first()->password;
        return $cryptor->decrypt($password);
    }
}