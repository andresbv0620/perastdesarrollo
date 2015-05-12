<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Permission;
use App\Role;
use Illuminate\Support\Facades\Redirect;
use Zizaco\Entrust\EntrustFacade;

Route::get('test', function(){
// A simple web site in Cloud9 that runs through Apache
// Press the 'Run' button on the top to start the web server,
// then click the URL that is emitted to the Output tab of the console


    $file=$_SERVER['DOCUMENT_ROOT'] . "/productos.txt";

    if(file_exists($file)){
        $filedata=file_get_contents($file);
        $obj2= json_decode($filedata, true);

        foreach($obj2 AS $user) {


            echo $useremail=$user['email'];

            $session = curl_init();
            $customer_id = $useremail; // You'll want to set this dynamically to the unique id of the user
            $customerio_url = 'https://track.customer.io/api/v1/customers/';
            $site_id = 'f26451698eec768748ed';
            $api_key = '736d7b6df3da07d68d55';

            $data = array('email' => $customer_id);

            curl_setopt($session, CURLOPT_URL, $customerio_url . $customer_id);
            curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($session, CURLOPT_HTTPGET, 1);
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($session, CURLOPT_VERBOSE, 1);
            curl_setopt($session, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($session, CURLOPT_USERPWD, $site_id . ':' . $api_key);

            curl_exec($session);
            curl_close($session);


            $productos=array("productos"=>$user['productos']);
            $json_encode=json_encode($productos,JSON_UNESCAPED_SLASHES);

             $session = curl_init();
             $customer_id = $useremail; // You'll want to set this dynamically to the unique id of the user associated with the event
             $customerio_url = 'https://track.customer.io/api/v1/customers/' . $customer_id . '/events';

             $site_id = 'f26451698eec768748ed';
             $api_key = '736d7b6df3da07d68d55';

             $data = array('name' => 'productosRedirigidos','data'=>$productos);

             curl_setopt($session, CURLOPT_URL, $customerio_url);
             curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
             curl_setopt($session, CURLOPT_HEADER, false);
             curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($session, CURLOPT_VERBOSE, 1);
             curl_setopt($session, CURLOPT_CUSTOMREQUEST, 'POST');
             curl_setopt($session, CURLOPT_POSTFIELDS, http_build_query($data));
             curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);

             curl_setopt($session, CURLOPT_USERPWD, $site_id . ':' . $api_key);

             curl_exec($session);
             curl_close($session);


            echo "<pre>";
            echo var_export($json_encode);
            echo "</pre>";

        }

    }






});

Route::get('contact',
    ['as' => 'contact', 'uses' => 'WelcomeController@create']);
Route::post('contact',
    ['as' => 'contact_store', 'uses' => 'WelcomeController@store']);

//EntrustFacade::routeNeedsRole('admin/planes*', 'superadmin', Redirect::to('/'));

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('roles', function(){
    $superadmin = new Role();
    $superadmin->name         = 'superadmin';
    $superadmin->display_name = 'Super Admin'; // optional
    $superadmin->description  = 'Puede crear administradores y tiene todos los permisos sobre los clientes asignados'; // optional
    $superadmin->save();

    $admin = new Role();
    $admin->name         = 'admin';
    $admin->display_name = 'Administrador'; // optional
    $admin->description  = 'Puede crear sistemas y usuarios segun el plan contratado '; // optional
    $admin->save();

    $recolector = new Role();
    $recolector->name         = 'recolector';
    $recolector->display_name = 'Usuario Recolector'; // optional
    $recolector->description  = 'Tiene acceso a los formularios para ingresar información desde el dispositivo movil'; // optional
    $recolector->save();

    $reportes = new Role();
    $reportes->name         = 'reportes';
    $reportes->display_name = 'Usuario Reportes'; // optional
    $reportes->description  = 'Tiene acceso a ver y generar reportes'; // optional
    $reportes->save();


    $createSystem = new Permission();
    $createSystem->name         = 'crear-sistema';
    $createSystem->display_name = 'Crear Sistemas'; // optional
// Allow a user to...
    $createSystem->description  = 'crear nuevo sistema asociado al administrador que lo crea'; // optional
    $createSystem->save();

    $createPlan = new Permission();
    $createPlan->name         = 'crear-plan';
    $createPlan->display_name = 'Crear Planes'; // optional
// Allow a user to...
    $createPlan->description  = 'crear planes'; // optional
    $createPlan->save();

    $todos = new Permission();
    $todos->name         = 'todos';
    $todos->display_name = 'Todos'; // optional
// Allow a user to...
    $todos->description  = 'Todos los permisos de los demas usuarios'; // optional
    $todos->save();

    $admin->attachPermission($createSystem);
// equivalent to $admin->perms()->sync(array($createPost->id));

    $superadmin->attachPermissions(array($todos));
// equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));

});




Route::controllers([
	'users'=>'UsersController',
    'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);



Route::group(['prefix'=>'admin','namespace'=>'\Admin'], function(){
    Route::resource('users','UsersController');
    Route::resource('planes','PlanesController');
    Route::resource('catalogs','CatalogsController');
    Route::resource('sistemas','SistemasController');

    Route::get('tabs/catalogid/{catalogoid}',['uses'=>'TabsController@tabcatalog','as'=>'admin.tabs.tabcatalog']);
    Route::resource('tabs','TabsController');
    Route::resource('entradas','EntradasController');
    Route::resource('inputs','InputsController');
});

Route::group(array('prefix' => 'api/v1','namespace'=>'\API'), function()
{
    Route::resource('users','UsersController');
    Route::resource('catalogs','CatalogsController');

});

Route::post('tenant', [
    'as' => 'tenants_path',
    'uses' => 'TenantsController@store'
]);

