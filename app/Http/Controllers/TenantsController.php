<?php namespace App\Http\Controllers;


use App\Context\TenantContextSession;
use Illuminate\Support\Facades\Input;

class TenantsController extends Controller {


    public function store()
    {

        $context= new TenantContextSession();
        $context->setConnectionName(Input::get('tenant_connection'));


        //Con el bloque de abajo sale un error por llamar a una funcion statica, ver facades.
        /*TenantContextSession::setConnectionName(Input::get('tenant_connection'));
        TenantContextSession::setTenantId(Input::get('tenant_id'));*/

        return \Redirect::route('admin.catalogs.index');
    }
}