<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombreDataBase','description'];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function tablets(){
        return $this->belongsToMany('App\Tablet');
    }


}
