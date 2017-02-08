<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/20/2016
 * Time: 12:39 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $primaryKey = 'Id';

    protected $fillable = ['Name',
        'Description',
        'Assignee',
        'Status'];

    public static function updateCampaign($campaign,$description,$assignee,$status) {
        $query = Campaign::query();
        $query->where('Id',$campaign->Id);
        $update = array();
        if(!empty($description)) {
            $update['Description'] = $description;
        }
        if(!empty($assignee)) {
            $update['Assignee'] = $assignee;
        }
        if(!empty($status)) {
            $update['Status'] = $status;
        }

        $query->update($update);
        $query->get();
    }

    public static function getAllActiveCampaigns() {
        return Campaign::where('Status','active')->get();
    }
}