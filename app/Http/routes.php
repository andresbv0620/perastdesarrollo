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

