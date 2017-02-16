<?php

namespace App\Models;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\Cryptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mailing_List_Groups extends Model
{
    protected $table = 'mailing_list_groups';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['company_id','name'];

    public static function queryGroups() {
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
            $users = DB::table('mailing_list_groups')
                ->leftJoin('companies','mailing_list_groups.company_id','companies.id')
                ->select('mailing_list_groups.id','mailing_list_groups.id','mailing_list_groups.name')
                ->where('mailing_list_groups.company_id','=',$user->company_id)
                ->orderBy('mailing_list_groups.id', 'asc')
                ->get();
            return $users;
        }



        $users = DB::table('mailing_list_groups')
            ->leftJoin('companies','mailing_list_groups.company_id','companies.id')
            ->select('mailing_list_groups.id','mailing_list_groups.id','mailing_list_groups.name','companies.name as company_name')
            ->orderBy('mailing_list_groups.id', 'asc')
            ->get();
        return $users;
    }
}