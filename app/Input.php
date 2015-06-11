<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Input extends Model {

    protected $fillable = ['*'];
    protected $hidden = ['_token','created_at','updated_at'];

    public function scopeFind($query, $item){
        if(trim($item) != '') {
            //$query->where(DB::raw("CONCAT(name,' ',email)"), "LIKE", "%$item%");
        }
    }

}
