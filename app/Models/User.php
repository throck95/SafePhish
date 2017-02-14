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

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        ['username',
        'email',
        'first_name',
        'last_name',
        'middle_initial',
        'password',
        'two_factor_enabled',
        'user_type'];

    public static function updateUser(User $user, $email, $password, $twoFactor, $userType = '') {
        $query = User::query();
        $query->where('id',$user->Id);
        $update = array();

        if(!empty($email)) {
            $update['email'] = $email;
        }
        if(!empty($password)) {
            $update['password'] = $password;
        }
        if(!empty($twoFactor)) {
            if($twoFactor) {
                $update['two_factor_enabled'] = 1;
            } else {
                $update['two_factor_enabled'] = 0;
            }
        }
        if(!empty($userType)) {
            $update['user_type'] = $userType->id;
        }

        $query->update($update);
        return $query->get();
    }

    public static function queryUsers() {
        $users = DB::table('users')
             ->leftJoin('user_permissions','users.user_type','user_permissions.id')
            ->select('users.id','users.username','users.email','users.first_name',
                'users.last_name','users.middle_initial','user_permissions.permission_type')
            ->orderBy('users.id', 'asc')
            ->get();
        /*$user = \Session::get('authUser');
        for($i = 0; $i < count($users); $i++) {
            if($users[$i]->id == $user->id) {
                unset($users[$i]);
                break;
            }
        }*/
        return $users;
    }
}
