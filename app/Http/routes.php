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

use App\Catalog;
use App\Entrada;
use App\Http\Controllers\Admin\OnTheFly;
use App\Opcione;
use App\Permission;
use App\Role;
use App\Sistema;
use App\Tab;
use App\Tablet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Zizaco\Entrust\EntrustFacade;

Route::get('test', function(){

    $webhookContent = "";
    $webhookContent='[{"$distinct_id": "14d49cb3ef663b-0e022d162f75e88-4b594236-100200-14d49cb3ef769c", "$properties": {"$initial_referring_domain": "$direct", "$created": "2015-05-12T15:22:57", "$last_seen": "2015-05-12T15:23:14", "First Login Date": "2015-05-12T15:22:47", "$timezone": "America/Bogota", "$city": "Santiago De Cali", "$country_code": "CO", "Last_Redirected_Product": "Bolso Jorah", "productosRedirigidos": ["Bolso Jorah"], "$campaigns": [544735, 550211, 550221], "$os": "Windows", "Lifetime Revenue": 63960, "$deliveries": [671969241, 671973371, 671990973], "$email": "323@test.co", "$initial_referrer": "$direct", "Place": "Footer", "Redirected": 1, "$transactions": [{"$time": "2015-05-12T15:23:14", "$amount": 63960}], "Last_Redirected_Product_imgUrl": "http://www.santorini.com.co/eShop/ProductImages/7015478_2.jpg", "Last_Redirected_Product_Tienda": "www.santorini.com.co", "$region": "Valle del Cauca", "$browser_version": 38, "redirect_url": ["http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478"], "$browser": "Firefox", "Last Redirected": "2015-05-12T15:23:10", "Last_Redirected_Product_url": "http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478", "Last_Redirected_Product_Precio": "63960"}}, {"$distinct_id": "14d49ca52d83c2-00608f6e1f6cde8-4b594236-100200-14d49ca52d96bc", "$properties": {"$initial_referring_domain": "$direct", "$created": "2015-05-12T15:21:55", "$last_seen": "2015-05-12T15:22:12", "First Login Date": "2015-05-12T15:21:46", "$timezone": "America/Bogota", "$city": "Santiago De Cali", "$country_code": "CO", "Last_Redirected_Product": "Bolso Jorah", "productosRedirigidos": ["Bolso Jorah"], "$campaigns": [544735, 550211, 550221], "$os": "Windows", "Lifetime Revenue": 63960, "$deliveries": [671969241, 671973371, 671990973], "$email": "321@test.co", "$initial_referrer": "$direct", "Place": "Footer", "Redirected": 1, "$transactions": [{"$time": "2015-05-12T15:22:12", "$amount": 63960}], "Last_Redirected_Product_imgUrl": "http://www.santorini.com.co/eShop/ProductImages/7015478_2.jpg", "Last_Redirected_Product_Tienda": "www.santorini.com.co", "$region": "Valle del Cauca", "$browser_version": 38, "redirect_url": ["http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478"], "$browser": "Firefox", "Last Redirected": "2015-05-12T15:22:08", "Last_Redirected_Product_url": "http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478", "Last_Redirected_Product_Precio": "63960"}}, {"$distinct_id": "14d49c49baea-0c3c5aa10e132c8-4b594236-100200-14d49c49baf64b", "$properties": {"$initial_referring_domain": "$direct", "$created": "2015-05-12T15:17:08", "$last_seen": "2015-05-12T15:21:18", "First Login Date": "2015-05-12T15:15:32", "$timezone": "America/Bogota", "$city": "Santiago De Cali", "$country_code": "CO", "Last_Redirected_Product": "Bolso Jorah", "productosRedirigidos": ["Bolso Jorah", "Bolso Jorah"], "$campaigns": [544735, 550211, 550221], "$os": "Windows", "Lifetime Revenue": 127920, "$deliveries": [671969241, 671973371, 671990973], "$email": "316@test.co", "$initial_referrer": "$direct", "Place": "Footer", "Redirected": 2, "$transactions": [{"$time": "2015-05-12T15:20:16", "$amount": 63960}, {"$time": "2015-05-12T15:21:18", "$amount": 63960}], "Last_Redirected_Product_imgUrl": "http://www.santorini.com.co/eShop/ProductImages/7015478_2.jpg", "Last_Redirected_Product_Tienda": "www.santorini.com.co", "$region": "Valle del Cauca", "$browser_version": 38, "redirect_url": ["http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478", "http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478"], "$browser": "Firefox", "Last Redirected": "2015-05-12T15:21:14", "Last_Redirected_Product_url": "http://www.santorini.com.co/eShop/Product.aspx?ProductId=7015478", "Last_Redirected_Product_Precio": "63960"}}]';

//if($_POST["users"]){
//$decode=json_decode($webhookContent, true);
//$useremail=$decode[0]['$properties']['$email'];
//$useremail2=$decode[1]['$properties']['$email'];
//////////////Test the webhook in a file//////////////////////
    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
    fwrite($fp,$webhookContent);
    fclose($fp);

//$self = $_SERVER['PHP_SELF']; //Obtenemos la página en la que nos encontramos
//header("refresh:10; url=$self"); //Refrescamos cada 300 segundos


    $obj2=json_decode($webhookContent, true);


    $similarUrl='http://adiktivo.com/search_similar?search=&category=mujer';

    foreach($obj2 AS $user) {

        /////////Email del usuario///////////
        $useremail=$user['$properties']['$email'];



        /////////////Producto Redirigido/////////////////////
        $rproducto=$user['$properties']['Last_Redirected_Product'];
        $rprecio=$user['$properties']['Last_Redirected_Product_Precio'];
        $rtienda=$user['$properties']['Last_Redirected_Product_Tienda'];
        $rurl=$user['$properties']['Last_Redirected_Product_url'];
        $rimg=$user['$properties']['Last_Redirected_Product_imgUrl'];

        $producto=array(
            'Producto'=>$rproducto,
            'Precio'=>$rprecio,
            'Tienda'=>$rtienda,
            'url'=>$rurl,
            'img_url'=>$rimg
        );

        $i=0;
        $arrayProductos['producto'.$i]=$producto;
        $i++;


        ////////////////////Se hace la consulta al recurso de ADIKTIVO para traer relacionados//////////////////
        $result = mb_substr($rproducto, 0, 6);
        $newurl = substr_replace($similarUrl, $result, 42, 0);
        $newurl = str_replace(' ', '', $newurl);

        $similares = file_get_contents($newurl);
        $jsonSimilares=json_decode($similares, true);



        foreach($jsonSimilares AS $similar) {
            echo "-";
            $producto=array(
                'Producto'=>$similar['description'],
                'Precio'=>$similar['price'],
                'Tienda'=>$similar['provider'],
                'url'=> $similar['shopurl'],
                'img_url'=>$similar['imageurl']
            );
            $arrayProductos['producto'.$i]=$producto;
            $i++;
            echo $i;
        }
        $arrayFinal[]=array('email'=>$useremail,'productos'=>$arrayProductos);
    }



    $json_encode = json_encode($arrayFinal, JSON_UNESCAPED_SLASHES);

    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/productos.txt","wb");
    fwrite($fp,$json_encode);
    fclose($fp);


    echo "<pre>";
    echo var_export($json_encode);
    echo "</pre>";

    ///////////////////////////////////////////////////////////

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
    Route::resource('users', 'UsersController');
    Route::resource('planes','PlanesController');
    Route::resource('catalogs','CatalogsController');
    Route::resource('sistemas','SistemasController');

    Route::get('tabs/catalogid/{catalogoid}',['uses'=>'TabsController@tabcatalog','as'=>'admin.tabs.tabcatalog']);
    Route::resource('tabs','TabsController');
    Route::resource('entradas','EntradasController');
    Route::resource('inputs','InputsController');
    Route::resource('tablets','TabletsController');
});

Route::group(array('prefix' => 'api/v1','namespace'=>'\API','middleware'=>'tabletauth'), function()
{
    Route::resource('users','UsersController');
    Route::resource('catalogs','CatalogsController');

    Route::post('apitest',function(Request $request){
        $tablet_id=$request->input('tablet_id');
        $users = User::all();
        foreach($users as $user){
            $sistemas=$user->sistemas;
            $user=array(
                'user'=>$users->toArray(),
                'sistemas'=>$sistemas->toArray()
            );
        }

        $response = array(
            'error' => 0,
            'users' => $user
        );
        return Response::json($response);
    });

    Route::post('sistemas',function(Request $request){
        $tablet_id=$request->input('tablet_id');
        $tablet=Tablet::findOrFail($tablet_id);
        $sistemas = $tablet->sistemas;
        foreach($sistemas as $sistema) {
            $users = $sistema->users;
        }
        $response = array(
            'error' => 0,
            'sistemas' => $sistemas
        );
        return Response::json($response);
    });

    Route::post('catalogos',function(Request $request){
        $tablet_id=$request->input('tablet_id');

        $tablet=Tablet::findOrFail($tablet_id);
        $sistemas = $tablet->sistemas;
        $sistemas=$sistemas->toArray();

        $sistemasArray=array();

        foreach($sistemas as $sistema) {
            $newconnection=$sistema['nombre_db'];


            $otf = new OnTheFly(['database' => $newconnection]);
            $catalogs = Catalog::on($newconnection)->get();//Retrieves an objet, it is needed to use toArray()
            $catalogs = $catalogs->toArray();
            //$catalogs = $otf->getTable('catalogs')->get();//Retrieves an array, there is no need to convert to array, just one line
            $catalogosArray=array();
            foreach($catalogs as $catalog){
                $tabs=Tab::on($newconnection)->where('catalog_id','=',$catalog['id'])->get();
                $tabs=$tabs->toArray();
                $tabsArray=array();
                foreach($tabs as $tab){
                    $entradas=Entrada::on($newconnection)->where('tab_id','=',$tab['id'])->get();
                    $entradas=$entradas->toArray();
                    $entradasArray=array();
                    foreach($entradas as $entrada){
                        $opciones=Opcione::on($newconnection)->where('entrada_id','=',$entrada['id'])->get();
                        $opciones=$opciones->toArray();

                        $entrada['opciones']=$opciones;
                        $entradasArray[]=$entrada;
                    }
                    $tab['entradas']=$entradasArray;
                    $tabsArray[]=$tab;
                }
                $catalog['tabs']=$tabsArray;
                $catalogosArray[]=$catalog;
                //var_dump($tabsArray);
            }

            $sistema['catalogos']=$catalogosArray;
            $sistemasArray[]=$sistema;
            //var_dump($catalogosArray);
        }
        $response = array(
            'sistemas' => $sistemasArray,
        );
        return Response::json($response);
    });
});

Route::post('tenant', [
    'as' => 'tenants_path',
    'uses' => 'TenantsController@store'
]);

