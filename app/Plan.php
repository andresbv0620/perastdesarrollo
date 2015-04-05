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
        'usuariosAdmins',
        'usuariosReportes',
        'cantidadTablets',
        'sistemas',
        'duracion',
        'precio',
        'periodicidad',
        'planCol'
    ];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}

