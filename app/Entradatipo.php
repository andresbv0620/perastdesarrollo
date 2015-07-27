<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Entradatipo extends Model {


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_entrada',
        'display_tipo_entrada'
    ];

    public function entradas(){
        return $this->hasMany('App\Entrada');
    }


}
