<?php
/**
 * Created by PhpStorm.
 * User: tthrockmorton
 * Date: 7/27/2016
 * Time: 11:26 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mailing_List_User extends Model
{
    protected $table = 'mailing_list';

    protected $primaryKey = 'Id';

    protected $fillable =
        ['Email',
            'FirstName',
            'LastName',
            'Department',
            'UniqueURLId'
        ];

    public static function updateMailingListUser($mlu, $email, $fname, $lname, $departmentID, $uniqueURLId) {
        $query = Mailing_List_User::query();
        $query->where('Id',$mlu->Id);
        $update = array();

        if(!empty($email)) {
            $update['Email'] = $email;
        }
        if(!empty($fname)) {
            $update['FirstName'] = $fname;
        }
        if(!empty($lname)) {
            $update['LastName'] = $lname;
        }
        if(!empty($departmentID)) {
            $update['Department'] = MLU_Departments::where('Id',$departmentID)->first()->Id;
        }
        if(!empty($uniqueURLId)) {
            $update['UniqueURLId'] = $uniqueURLId;
        }

        $query->update($update);
        $query->get();
    }
}