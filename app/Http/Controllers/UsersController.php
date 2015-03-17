<?php namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller {

    public function getOrm(){
        $result=User::first();
        dd($result);
    }

    public function getIndex(){
        $result = \DB::table('users')
            ->select(['users.*','plan.nombre','plan.duracion'])
            ->orderBy('id','ASC')
            ->join('cliente_has_plan','users.id','=','cliente_has_plan.id_cliente')
            ->join('plan','plan.id','=','cliente_has_plan.id_plan')
            ->get();
        dd($result);
        return $result;
    }
}