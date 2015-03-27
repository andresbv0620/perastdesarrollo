<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\DB\User\Traits\UserACL;
use App\DB\User\Traits\UserAccessors;
use App\DB\User\Traits\UserQueryScopes;
use App\DB\User\Traits\UserRelationShips;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

    /**
     * Application's Traits (Separation of various types of methods)
     */
    use UserACL, UserRelationShips;


    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','pagina','imagenFondo','logo'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function sistema(){
        return $this->hasMany('App\Sistema');
    }
    public function plan(){
        return $this->hasMany('App\Plan');
    }

    public function setPasswordAttribute($value){

        if(!empty($value)){
        $this->attributes['password']=\Hash::make($value);
        }
    }

}
