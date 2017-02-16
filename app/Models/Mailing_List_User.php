<?php

namespace App\Models;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\Cryptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mailing_List_User extends Model
{
    protected $table = 'mailing_list';

    protected $primaryKey = 'id';

    protected $fillable =
        ['company_id',
            'email',
            'first_name',
            'last_name',
            'unique_url_id'
        ];

    public static function updateMailingListUser($mlu, $email, $fname, $lname, $uniqueURLId = '') {
        $query = Mailing_List_User::query();
        $query->where('id',$mlu->id);
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

    public static function queryMLU() {
        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        if(empty($session)) {
            Auth::logout();
        }

        $user = User::where('id',$session->user_id)->first();

        if(empty($user)) {
            Auth::logout();
        }

        if($user->company_id !== 1) {
            $users = DB::table('mailing_list')
                ->leftJoin('companies','mailing_list.company_id','companies.id')
                ->select('mailing_list.id','mailing_list.id','mailing_list.email','mailing_list.first_name',
                    'mailing_list.last_name','mailing_list.unique_url_id')
                ->where('mailing_list.company_id','=',$user->company_id)
                ->orderBy('mailing_list.id', 'asc')
                ->get();
            return $users;
        }


        $users = DB::table('mailing_list')
            ->leftJoin('companies','mailing_list.company_id','companies.id')
            ->select('mailing_list.id','mailing_list.id','mailing_list.email','mailing_list.first_name',
                'mailing_list.last_name','mailing_list.unique_url_id','companies.name')
            ->orderBy('mailing_list.id', 'asc')
            ->get();
        return $users;
    }
}