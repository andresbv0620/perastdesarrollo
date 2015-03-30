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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');




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


