<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Context\TenantContextSession;
use Illuminate\Support\Facades\Session;

class Catalog extends Model {


    protected $connection = 'sistema_2';

    //use TenantableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'description'
    ];

    public function tabs(){
        return $this->hasMany('App\Tab');
    }
}
