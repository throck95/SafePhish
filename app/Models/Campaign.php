<?php

namespace App\Models;

use App\Http\Controllers\AuthController as Auth;
use App\Libraries\Cryptor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $primaryKey = 'id';

    protected $fillable = ['name',
        'description',
        'assignee',
        'status'];

    public static function updateCampaign($campaign,$description,$assignee,$status) {
        $query = Campaign::query();
        $query->where('id',$campaign->id);
        $update = array();
        if(!empty($description)) {
            $update['description'] = $description;
        }
        if(!empty($assignee)) {
            $update['assignee'] = $assignee;
        }
        if(!empty($status)) {
            $update['status'] = $status;
        }

        $query->update($update);
        $query->get();
    }

    public static function getAllActiveCampaigns() {
        return Campaign::where('status','active')->get();
    }

    public static function queryCampaigns() {
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
            $users = DB::table('campaigns')
                ->leftJoin('users','campaigns.assignee','users.id')
                ->leftJoin('companies','users.company_id','companies.id')
                ->select('campaigns.id','campaigns.name','campaigns.description','campaigns.status','campaigns.created_at',
                    'campaigns.updated_at','users.first_name','users.last_name','users.id as user_id','companies.name as company_name')
                ->where('users.company_id','=',$user->company_id)
                ->orderBy('campaigns.id', 'asc')
                ->get();
            return $users;
        }

        $users = DB::table('campaigns')
            ->leftJoin('users','campaigns.assignee','users.id')
            ->leftJoin('companies','users.company_id','companies.id')
            ->select('campaigns.id','campaigns.name','campaigns.description','campaigns.status','campaigns.created_at',
                'campaigns.updated_at','users.first_name','users.last_name','users.id as user_id','companies.name as company_name')
            ->orderBy('campaigns.id', 'asc')
            ->get();
        return $users;
    }
}