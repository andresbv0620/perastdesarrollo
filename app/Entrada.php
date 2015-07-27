<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Entrada extends Model {

/*    public function __construct(){
        $database=Session::get('tenant_connection');
        $this->connection=$database;
    }*/

    //protected $connection = 'sistema_2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_name',
        'field_description',
        'field_required',
        'opdinamica_id',
        'campo_opcion',
        'entradaprincipal_id',
        'consulta'
    ];

    public function tab(){
        return $this->belongsTo('App\Tab');
    }

    public function opciones(){
        return $this->hasMany('App\Opcione');
    }

    public function entradatipo(){
        return $this->belongsTo('App\Entradatipo');
    }}
