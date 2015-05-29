<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;



class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    use EntrustUserTrait;

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
    ///No se esconde el password para poder pasarlo al api
	protected $hidden = ['remember_token','imagenFondo','logo'];

    public function sistemas(){
        return $this->belongsToMany('App\Sistema');
    }

    public function plans(){
        return $this->belongsToMany('App\Plan');
    }

    public function setPasswordAttribute($value){

        if(!empty($value)){
        $this->attributes['password']=\Hash::make($value); //bcrypt($value);
        }
    }

    /**
     * @param $query
     * @param $name
     */
    public function scopeName($query, $name){
        if(trim($name) != '') {
            $query->where(DB::raw("CONCAT(name,' ',email)"), "LIKE", "%$name%");
        }
    }



}
