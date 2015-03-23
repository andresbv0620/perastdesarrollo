<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model {


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

    public function entrada(){
        return $this->hasMany('App\Entrada');
    }

}
