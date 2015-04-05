<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablet extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUnicoTablet',
        'description'
    ];

    public function sistemas(){
        return $this->belongsToMany('App\Sistema');
    }

}
