<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;


    protected $table = 'users';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        ['Username',
        'Email',
        'FirstName',
        'LastName',
        'MiddleInitial',
        'Password',
        '2FA',
        'UserType'];

    public static function updateUser($user, $email, $password, $twoFactor, $userType = '') {
        $query = User::query();
        $query->where('Id',$user->Id);
        $update = array();

        if(!empty($email)) {
            $update['Email'] = $email;
        }
        if(!empty($password)) {
            $update['Password'] = $password;
        }
        if(!empty($twoFactor)) {
            if($twoFactor) {
                $update['2FA'] = 1;
            } else {
                $update['2FA'] = 0;
            }
        }
        if(!empty($userType)) {
            $update['UserType'] = $userType->Id;
        }

        $query->update($update);
        return $query->get();
    }

    public static function queryUsers() {
        $users = DB::table('users')
             ->leftJoin('user_permissions','users.UserType','user_permissions.Id')
            ->select('users.Id','users.Username','users.Email','users.FirstName',
                'users.LastName','users.MiddleInitial','user_permissions.PermissionType')
            ->orderBy('users.Id', 'asc')
            ->get();
        $user = \Session::get('authUser');
        for($i = 0; $i < count($users); $i++) {
            if($users[$i]->Id == $user->Id) {
                unset($users[$i]);
                break;
            }
        }
        return $users;
    }
}
