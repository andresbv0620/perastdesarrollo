<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function tab(){
        return $this->hasMany('App\Tab');

}

}
