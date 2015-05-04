<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcione extends Model {

    protected $connection = 'sistema_2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name',
        'option_order'
    ];

    public function entrada(){
        return $this->belongsTo('App\Entrada');
    }

}
