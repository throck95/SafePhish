<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/20/2016
 * Time: 12:39 PM
 */

namespace App\Models;


use App\Libraries\Cryptor;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Driver\Exception\DuplicateKeyException;

class Campaign_Email_Addresses extends Model
{
    protected $table = 'campaign_email_addresses';

    protected $primaryKey = 'Id';

    protected $fillable = ['Email_Address',
        'Name',
        'Password'];

    public static function insertEmail($email, $name, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::where('Email_Address',$email)->first();
        if(count($query)) {
            throw new DuplicateKeyException("Email Address already exists.");
        }
        return self::create([
            'Email_Address'=>$email,
            'Name'=>$name,
            'Password'=>$encrypted
        ]);
    }

    public static function updateEmail($email, $name, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::query();
        $query->where('Email_Address',$email);
        $query->update(['Password'=>$encrypted,'Name'=>$name]);
        return $query->get();
    }

    public static function decryptPassword($email) {
        $cryptor = new Cryptor();
        $password = self::where('Email_Address',$email)->first()->Password;
        return $cryptor->decrypt($password);
    }
}