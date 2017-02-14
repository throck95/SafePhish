<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing_List_User extends Model
{
    protected $table = 'mailing_list';

    protected $primaryKey = 'id';

    protected $fillable =
        ['email',
            'first_name',
            'last_name',
            'unique_url_id'
        ];

    public static function updateMailingListUser($mlu, $email, $fname, $lname, $uniqueURLId = '') {
        $query = Mailing_List_User::query();
        $query->where('id',$mlu->Id);
        $update = array();

        if(!empty($email)) {
            $update['email'] = $email;
        }
        if(!empty($fname)) {
            $update['first_name'] = $fname;
        }
        if(!empty($lname)) {
            $update['last_name'] = $lname;
        }
        if(!empty($uniqueURLId)) {
            $update['unique_url_id'] = $uniqueURLId;
        }

        $query->update($update);
        $query->get();
    }
}