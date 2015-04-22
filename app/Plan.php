<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    //protected $table = 'plans';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'capacidad',
        'cantidadTablets',
        'sistemas',
        'duracion',
        'precio',
        'periodicidad'
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

