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

use App\Role;

Route::get('contact',
    ['as' => 'contact', 'uses' => 'WelcomeController@create']);
Route::post('contact',
    ['as' => 'contact_store', 'uses' => 'WelcomeController@store']);


Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('roles', function(){
    $owner = new Role();
    $owner->name         = 'superadmin';
    $owner->display_name = 'Super Admin'; // optional
    $owner->description  = 'Puede crear administradores y tiene todos los permisos sobre los clientes asignados'; // optional
    $owner->save();

    $admin = new Role();
    $admin->name         = 'admin';
    $admin->display_name = 'Administrador'; // optional
    $admin->description  = 'Puede crear sistemas y usuarios segun el plan contratado '; // optional
    $admin->save();

    $admin = new Role();
    $admin->name         = 'recolector';
    $admin->display_name = 'Usuario Recolector'; // optional
    $admin->description  = 'Tiene acceso a los formularios para ingresar información desde el dispositivo movil'; // optional
    $admin->save();

    $admin = new Role();
    $admin->name         = 'reportes';
    $admin->display_name = 'Usuario Reportes'; // optional
    $admin->description  = 'Tiene acceso a ver y generar reportes'; // optional
    $admin->save();
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
});



