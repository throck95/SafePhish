<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        $query->where('id',$campaign->Id);
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
}