<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Tab extends Model {

    protected $connection = 'sistema_2';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function catalog(){
        return $this->belongsTo('App\Catalog');
    }

    public function entradas(){
        return $this->hasMany('App\Entrada');
    }

}
