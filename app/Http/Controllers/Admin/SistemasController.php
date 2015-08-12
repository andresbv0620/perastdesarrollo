<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Requests\CreateSistemaRequest;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tablet;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Zizaco\Entrust\EntrustFacade;

class SistemasController extends Controller {

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        $this->middleware('auth');
        $this->request = $request;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $isuser=User::all()->first();
        if(!empty($isuser)) {
            if (EntrustFacade::hasRole('superadmin')) {
                $user = Auth::user()->id;
                $sistemas = Sistema::paginate();

            } elseif (EntrustFacade::hasRole('admin')) {
                $user = Auth::user()->id;
                $sistemas = User::findOrFail($user)->sistemas()->paginate();
            }
            return view('admin.sistemas.index', compact('sistemas', 'user'));
        }else{
            Session::flash('message','Antes de empezar debe Registrar un usuario');
            return redirect()->route('admin.users.index');
        }

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $isuser=User::all()->first();
        if(!empty($isuser)) {
            $users = User::all();
            $usercheckeds = array();
            return view('admin.sistemas.create', compact('users', 'usercheckeds'));
        }else{
            Session::flash('message','Antes de empezar debe Registrar un usuario');
            return redirect()->route('admin.users.index');
        }
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateSistemaRequest $request)
	{
        ////////////Capturar Imagen de Fondo////////////////////
        $fondo_name= $_FILES["imagenFondo"]["name"];
        $fondo_size= $_FILES["imagenFondo"]["size"];
        $fondo_type= $_FILES["imagenFondo"]["type"];
        $fondo_temporal= $_FILES["imagenFondo"]["tmp_name"];

        if($fondo_size>1000000 ){
            Session::flash('message','El tamaño de imagen máximo permitido para el fondo es 2 Mb');
            return redirect()->back();
        }

        # Limitamos los formatos de imagen admitidos a: png, jpg y gif
        if ($fondo_type=="image/x-png" OR $fondo_type=="image/png")
        {
            $extension="image/png";
        }
        if ($fondo_type=="image/pjpeg" OR $fondo_type=="image/jpeg")
        {
            $extension="image/jpeg";
        }
        if ($fondo_type=="image/gif" OR $fondo_type=="image/gif")
        {
            $extension="image/gif";
        }

        /*Reconversion de la imagen para meter en la tabla abrimos el fichero temporal en modo lectura "r" y binaria "b"*/
        $f1= fopen($fondo_temporal,"rb");

        # Leemos el fichero completo limitando la lectura al tamaño del fichero
        $fondo_reconvertida = fread($f1, $fondo_size);

        /* Anteponemos "\" a las comillas que pudiera contener el fichero para evitar que sean interpretadas como final de cadena.*/
        $fondo_reconvertida = base64_encode($fondo_reconvertida);

        //cerrar el fichero temporal
        fclose($f1);
        ////////////////////////////Fin imagen de fondo/////////////////////////

        /////////////////////////Capturar Logo////////////////////////////////////

        $logo_name= $_FILES["logo"]["name"];
        $logo_size= $_FILES["logo"]["size"];
        $logo_type= $_FILES["logo"]["type"];
        $logo_temporal= $_FILES["logo"]["tmp_name"];

        if($logo_size>1000000 ){
            Session::flash('message','El tamaño de imagen de logo máximo permitido es 2 Mb');
            return redirect()->back();
        }

        # Limitamos los formatos de imagen admitidos a: png, jpg y gif
        if ($logo_type=="image/x-png" OR $logo_type=="image/png")
        {
            $extension="image/png";
        }
        if ($logo_type=="image/pjpeg" OR $logo_type=="image/jpeg")
        {
            $extension="image/jpeg";
        }
        if ($logo_type=="image/gif" OR $logo_type=="image/gif")
        {
            $extension="image/gif";
        }

        /*Reconversion de la imagen para meter en la tabla abrimos el fichero temporal en modo lectura "r" y binaria "b"*/
        $f1= fopen($logo_temporal,"rb");

        # Leemos el fichero completo limitando la lectura al tamaño del fichero
        $logo_reconvertida = fread($f1, $logo_size);

        /* Anteponemos "\" a las comillas que pudiera contener el fichero para evitar que sean interpretadas como final de cadena.*/
        $logo_reconvertida = base64_encode($logo_reconvertida);

        //cerrar el fichero temporal
        fclose($f1);

        //////////////////////////Fin Capturar Logo//////////////////////
        //$bytes=strlen ($fondo_reconvertida);
        $dimensioneslogo=getimagesize($logo_temporal)[3];
        $dimensioneslogo=explode(' ',$dimensioneslogo);

        foreach($dimensioneslogo as $dimencionlogo){
            $dimencionlogo=explode('=',$dimencionlogo)[1];
            $dimencionlogo=(int)explode('"',$dimencionlogo)[1];


            if($dimencionlogo>800){
                Session::flash('message','Las dimensiones del logo no pueden ser superiores a 800px');
                return redirect()->back();
            }
        }

        $dimensionesfondo=getimagesize($fondo_temporal)[3];
        $dimensionesfondo=explode(' ',$dimensionesfondo);

        foreach($dimensionesfondo as $dimencionfondo){
            $dimencionfondo=explode('=',$dimencionfondo)[1];
            $dimencionfondo=(int)explode('"',$dimencionfondo)[1];



            if($dimencionfondo>800){
                Session::flash('message','Las dimensiones del fondo no pueden ser superiores a 800px');
                return redirect()->back();
            }
        }

        $data=$this->request->all();
		$sistema = new Sistema($data);
        $sistema->logo_sistema=$logo_reconvertida;
        $sistema->imagen_fondo=$fondo_reconvertida;
        $sistema->save();

        $users_id = Input::get('user_id');
        foreach($users_id as $userid) {
            $dbname = ($sistema->id). '_' .$userid;
            $sistema->nombre_db=$dbname;
        }
        $sistema->save();

        if(Input::get('user_id')=="") {
            $user_id = array();
            $sistema->users()->sync($user_id);
       }else{
            $sistema->users()->sync(Input::get('user_id'));
            $users_id = Input::get('user_id');
            foreach($users_id as $userid) {
                $connection=array();
                $dbname = ($sistema->id). '_' .$userid;
                $result = DB::statement(DB::raw('CREATE DATABASE ' . $dbname));

                $connection=array($dbname=>[
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => $dbname, 'forge',
                    'username'  => 'root', 'forge',
                    'password'  => 'pera99pera', '',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                    'strict'    => false,
                ]);

                Config::set('database.connections',$connection);

                Schema::connection($dbname)->create('catalogs', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('description');
                    $table->string('tipo');
                    $table->timestamps();
                });

                Schema::connection($dbname)->create('tabs', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('description');
                    $table->integer('catalog_id')->unsigned();
                    $table->timestamps();

                    $table->foreign('catalog_id')
                        ->references('id')
                        ->on('catalogs')
                        ->onDelete('cascade');
                });

                Schema::connection($dbname)->create('entradatipos', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('tipo_entrada');
                    $table->string('display_tipo_entrada');
                    $table->timestamps();
                });

                \DB::connection($dbname)->table('entradatipos')->insert([
                    ['tipo_entrada' => 'texto','display_tipo_entrada' => 'Texto'],
                    ['tipo_entrada' => 'parrafo','display_tipo_entrada' => 'Parrafo'],
                    ['tipo_entrada' => 'opcion_unica','display_tipo_entrada' => 'Opción Única'],
                    ['tipo_entrada' => 'opcion_multiple','display_tipo_entrada' => 'Opción Multiple'],
                    ['tipo_entrada' => 'foto','display_tipo_entrada' => 'Foto'],
                    ['tipo_entrada' => 'fecha','display_tipo_entrada' => 'Fecha'],
                    ['tipo_entrada' => 'numero','display_tipo_entrada' => 'Numero'],
                    ['tipo_entrada' => 'scan','display_tipo_entrada' => 'Scan'],
                    ['tipo_entrada' => 'opcion_dinamica','display_tipo_entrada' => 'Opción Dinamica'],
                    ['tipo_entrada' => 'gps','display_tipo_entrada' => 'GPS']
                ]);

                Schema::connection($dbname)->create('entradas', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('field_name');
                    $table->string('field_description');
                    $table->boolean('field_required')->default(true);
                    $table->integer('tab_id')->unsigned();
                    $table->integer('entradatipo_id')->unsigned();
                    $table->timestamps();

                    //Estos son los campos de la tabla pivot entre las opciones dinamicas y las entradas, la cual podria
                    // no ser necesaria.
                    $table->integer('opdinamica_id')->unsigned();
                    $table->integer('campo_opcion')->unsigned();
                    $table->integer('entradaprincipal_id')->unsigned();
                    $table->string('consulta');


                    $table->foreign('tab_id')
                        ->references('id')
                        ->on('tabs')
                        ->onDelete('cascade');

                    $table->foreign('entradatipo_id')
                        ->references('id')
                        ->on('entradatipos')
                        ->onDelete('cascade');

                });

                Schema::connection($dbname)->create('opciones', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('option_name');
                    $table->integer('option_order');
                    $table->integer('entrada_id')->unsigned();
                    $table->timestamps();

                    $table->foreign('entrada_id')
                        ->references('id')
                        ->on('entradas')
                        ->onDelete('cascade');
                });


                /*/////Tabla por defecto para respuestas de sistemas con opciones simples//////////
                Schema::connection($dbname)->create('inputs', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->timestamps();
                    $table->string('_token');

                });*/

                //Tabla pivot entre las opciones dinamicas (tabla respuesta catalogos) y la entrada
                //NOTA: No se puede pre-asociar una FK a la tabla opciones dinamicas porque esta se crea
                //on the fly, cada vez que un catalogo nuevo es creado. Tampoco se puede usar la convencion de nombres
                // de laravel porque no sabemos cual será el nombre de las multiples tablas de respuestas.
                //OTRA PROPUESTA: CREAR ESTA TABLA EN EL MOMENTO QUE SE CREA EL CATALOGO (O LA ENTRADA), GENERARIA UNA
                // TABLA DE ESTAS POR CADA TABLA DE RESPUESTAS.
                Schema::connection($dbname)->create('entrada_opdinamicas', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->integer('entrada_id')->unsigned();
                    $table->integer('opdinamica_id')->unsigned();
                    $table->integer('campo_opcion')->unsigned();
                    $table->integer('entradaprincipal_id')->unsigned();
                    $table->string('consulta');
                    $table->timestamps();
                    $table->foreign('entrada_id')
                        ->references('id')
                        ->on('entradas')
                        ->onDelete('cascade');
                });



                /*
                //Activar solo en caso de que se requiera crear estas tablas para cada sistema
                Schema::connection($dbname)->create('tablets', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('idUnicoTablet')->unique();
                    $table->string('description');
                    $table->timestamps();
                });

                Schema::connection($dbname)->create('users', function(Blueprint $table)
                {
                    $table->increments('id');

                    $table->string('name');
                    $table->string('email')->unique();
                    $table->string('password', 60);
                    $table->string('pagina');
                    $table->rememberToken();
                    $table->timestamps();
                });


                //Este fragmento guarda el usuario al que se le esta creando el sistema en la tabla users del sistema
                //sin embargo hay que tener cuidado porque debido al autoincrement no guarda el mismo id de la db maestra
                $user=User::findOrFail($userid);
                $user=$user->toArray();
                $usersys= new User($user);
                $usersys->setConnection($dbname);
                $usersys->save();

                */







            }
        }
            $sistemas = Sistema::paginate();
        $user=Auth::user()->id;

        return view('home', compact('sistemas','user'));


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $sistema=Sistema::findOrFail($id);
        $userid = Auth::user()->id;
        $dbname = ($sistema->nombreDataBase) . '_' .$userid;

        $otf = new OnTheFly(['database'=>$dbname]);
        $catalogs = Catalog::on($dbname)->paginate();

        // Get the users table Query Builder
        //$catalogs = $otf->getTable('catalogs');


       return view('admin.catalogs.index', compact('catalogs'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $sistema=Sistema::findOrFail($id);
        $logo=$sistema->logo_sistema;

        //Decodificamos $Base64Img codificada en base64.
        $Base64Img = base64_decode($logo);

        //escribimos la información obtenida en un archivo llamado
        //unodepiera.png para que se cree la imagen correctamente
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/img_sistemas/logo.png', $Base64Img);

        $tablets=$sistema->tablets;
        $users=User::all();
        $usercheckeds = $sistema->users()->lists('user_id');
        return view('admin.sistemas.edit',compact('sistema','tablets','users','usercheckeds'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        ////////////Capturar Imagen de Fondo////////////////////
        $fondo_name= $_FILES["imagenFondo"]["name"];
        $fondo_size= $_FILES["imagenFondo"]["size"];
        $fondo_type= $_FILES["imagenFondo"]["type"];
        $fondo_temporal= $_FILES["imagenFondo"]["tmp_name"];

        if($fondo_size>4000000 ){
            Session::flash('message','El tamaño de imagen máximo permitido para el fondo es 4 Mb');
            return redirect()->back();
        }

        # Limitamos los formatos de imagen admitidos a: png, jpg y gif
        if ($fondo_type=="image/x-png" OR $fondo_type=="image/png")
        {
            $extension="image/png";
        }
        if ($fondo_type=="image/pjpeg" OR $fondo_type=="image/jpeg")
        {
            $extension="image/jpeg";
        }
        if ($fondo_type=="image/gif" OR $fondo_type=="image/gif")
        {
            $extension="image/gif";
        }

        /*Reconversion de la imagen para meter en la tabla abrimos el fichero temporal en modo lectura "r" y binaria "b"*/
        $f1= fopen($fondo_temporal,"rb");

        # Leemos el fichero completo limitando la lectura al tamaño del fichero
        $fondo_reconvertida = fread($f1, $fondo_size);

        /* Anteponemos "\" a las comillas que pudiera contener el fichero para evitar que sean interpretadas como final de cadena.*/
        $fondo_reconvertida = base64_encode($fondo_reconvertida);

        //cerrar el fichero temporal
        fclose($f1);
        ////////////////////////////Fin imagen de fondo/////////////////////////

        /////////////////////////Capturar Logo////////////////////////////////////

        $logo_name= $_FILES["logo"]["name"];
        $logo_size= $_FILES["logo"]["size"];
        $logo_type= $_FILES["logo"]["type"];
        $logo_temporal= $_FILES["logo"]["tmp_name"];

        if($logo_size>4000000 ){
            Session::flash('message','El tamaño de imagen de logo máximo permitido es 4 Mb');
            return redirect()->back();
        }

        # Limitamos los formatos de imagen admitidos a: png, jpg y gif
        if ($logo_type=="image/x-png" OR $logo_type=="image/png")
        {
            $extension="image/png";
        }
        if ($logo_type=="image/pjpeg" OR $logo_type=="image/jpeg")
        {
            $extension="image/jpeg";
        }
        if ($logo_type=="image/gif" OR $logo_type=="image/gif")
        {
            $extension="image/gif";
        }

        /*Reconversion de la imagen para meter en la tabla abrimos el fichero temporal en modo lectura "r" y binaria "b"*/
        $f1= fopen($logo_temporal,"rb");

        # Leemos el fichero completo limitando la lectura al tamaño del fichero
        $logo_reconvertida = fread($f1, $logo_size);

        /* Anteponemos "\" a las comillas que pudiera contener el fichero para evitar que sean interpretadas como final de cadena.*/
        $logo_reconvertida = base64_encode($logo_reconvertida);

        //cerrar el fichero temporal
        fclose($f1);

        //////////////////////////Fin Capturar Logo//////////////////////


        $data =$this-> request->all ();
        $sistema=Sistema::findOrFail($id);
        $sistema->fill($data);
        $sistema->logo_sistema=$logo_reconvertida;
        $sistema->imagen_fondo=$fondo_reconvertida;
        $sistema->save();

        /*$tablet = new Tablet($data);
        $tablet->save ();
        $tablet->sistemas()->attach($sistema);*/
        //No es posible actualizar un usuario a un sistema despues de crearlo, se debe eliminar el sistema y crear uno nuevo asociandole los usuarios
        //$sistema->users()->sync(Input::get('user_id'));


        $sistemas=Sistema::paginate();
        $user=Auth::user()->id;
        return view('admin.sistemas.index', compact('sistemas','user'));


    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $sistema=Sistema::findOrFail($id);
        $users_id = $sistema->users;

        $sistema->delete();
        //Sistema::destroy($id);//Opcion

        foreach($users_id as $userid) {
            $dbname = ($sistema->id). '_' .$userid->id;
            $result = DB::statement(DB::raw('DROP DATABASE ' . $dbname));
        }


        $message='El sistema fue eliminado de nuestros registros';

        if($this->request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);

        return redirect()->route('admin.sistemas.index');
	}
}
