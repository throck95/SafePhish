<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/20/2016
 * Time: 12:39 PM
 */

namespace App\Models;


use App\Cryptor;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Driver\Exception\DuplicateKeyException;

class CampaignEmailAddresses extends Model
{
    protected $table = 'campaign_email_addresses';

    protected $primaryKey = 'Id';

    protected $fillable = ['Email_Address',
        'Password'];

    public static function insertEmail($email, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::where('Email_Address',$email)->first();
        if(count($query)) {
            throw new DuplicateKeyException("Email Address already exists.");
        }
        return self::create([
            'Email_Address'=>$email,
            'Password'=>$encrypted
        ]);
    }

    public static function updateEmail($email, $password) {
        $cryptor = new Cryptor();
        $encrypted = $cryptor->encrypt($password);
        unset($password);
        $query = self::query();
        $query->where('Email_Address',$email);
        $query->update(['Password'=>$encrypted]);
        return $query->get();
    }

    public static function decryptPassword($email) {
        $cryptor = new Cryptor();
        $password = self::where('Email_Address',$email)->first()->Password;
        return $cryptor->decrypt($password);
    }
}