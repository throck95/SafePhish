<?php

namespace App\Models;

use App\Libraries\Cryptor;
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
        ['email',
        'first_name',
        'last_name',
        'middle_initial',
        'password',
        'two_factor_enabled',
        'user_type',
        'company_id'];

    public static function updateUser(User $user, $email, $password, $twoFactor, $userType = '') {
        $query = User::query();
        $query->where('id',$user->id);
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
        $cryptor = new Cryptor();

        $sessionId = $cryptor->decrypt(\Session::get('sessionId'));
        $session = Sessions::where('id', $sessionId)->first();

        if(empty($session)) {

        }

        $user = User::where('id',$session->user_id)->first();

        if(empty($user)) {

        }

        if($user->company_id === 1) {
            $users = DB::table('users')
                ->leftJoin('user_permissions','users.user_type','user_permissions.id')
                ->leftJoin('companies','users.company_id','companies.id')
                ->select('users.id','users.email','users.first_name',
                    'users.last_name','users.middle_initial','user_permissions.permission_type','companies.name')
                ->where('users.id','!=',$user->id)
                ->orderBy('users.id', 'asc')
                ->get();
            return $users;
        }

        $users = DB::table('users')
             ->leftJoin('user_permissions','users.user_type','user_permissions.id')
            ->leftJoin('companies','users.company_id','companies.id')
            ->select('users.id','users.email','users.first_name',
                'users.last_name','users.middle_initial','user_permissions.permission_type')
            ->where('users.id','!=',$user->id)
            ->where('users.company_id','=',$user->company_id)
            ->orderBy('users.id', 'asc')
            ->get();
        return $users;
    }
}
