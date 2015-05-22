<?php namespace App\Http\Controllers;


use App\Context\TenantContextSession;
use App\Sistema;
use Illuminate\Support\Facades\Input;

class TenantsController extends Controller {


    public function store()
    {
        $context= new TenantContextSession();
        $context->setConnectionName(Input::get('tenant_connection'));

        $str_tenant=Input::get('tenant_connection');
        $strArray=explode('_',$str_tenant,2);
        $sistema_id=$strArray[0];
        $context->setTenantId($sistema_id);

        $sistema=Sistema::findOrFail($sistema_id);
        $logo=$sistema->logo_sistema;
        $fondo=$sistema->imagen_fondo;
        //Decodificamos $Base64Img codificada en base64.
        $Base64Img = base64_decode($logo);
        $Base64ImgFondo = base64_decode($fondo);

        $logo_path='/img_sistemas/logo'.$str_tenant.'.png';
        $fondo_path='/img_sistemas/fondo'.$str_tenant.'.png';
        //escribimos la información obtenida en un archivo
        //para que se cree la imagen correctamente
        file_put_contents($_SERVER["DOCUMENT_ROOT"].$logo_path, $Base64Img);
        \Session::put('logo_path', $logo_path);

        file_put_contents($_SERVER["DOCUMENT_ROOT"].$fondo_path, $Base64ImgFondo);
        \Session::put('fondo_path', $fondo_path);

        //Con el bloque de abajo sale un error por llamar a una funcion statica, ver facades.
        /*TenantContextSession::setConnectionName(Input::get('tenant_connection'));
        TenantContextSession::setTenantId(Input::get('tenant_id'));*/

        return \Redirect::route('admin.catalogs.index');
    }
}