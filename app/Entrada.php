<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'value',
        'esPrincipal'
    ];

    public function tab(){
        return $this->belongsTo('App\Tab');
    }

}
