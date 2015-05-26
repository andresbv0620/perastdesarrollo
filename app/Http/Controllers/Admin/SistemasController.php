<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Requests\CreateSistemaRequest;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tablet;
use App\User;
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

        if($fondo_size>8388608 ){
            Session::flash('message','El tamaño de imagen máximo permitido para el fondo es 8 Mb');
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

        if($logo_size>8388608 ){
            Session::flash('message','El tamaño de imagen de logo máximo permitido es 8 Mb');
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

                Schema::connection($dbname)->create('entradas', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('field_name');
                    $table->string('field_description');
                    $table->string('field_type');
                    $table->boolean('field_required')->default(true);
                    $table->integer('tab_id')->unsigned();
                    $table->timestamps();

                    $table->foreign('tab_id')
                        ->references('id')
                        ->on('tabs')
                        ->onDelete('cascade');
                });

                Schema::connection($dbname)->create('opciones', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->string('option_name');
                    $table->integer('option_order');
                    $table->string('field_type');
                    $table->integer('entrada_id')->unsigned();
                    $table->timestamps();

                    $table->foreign('entrada_id')
                        ->references('id')
                        ->on('entradas')
                        ->onDelete('cascade');
                });

                Schema::connection($dbname)->create('inputs', function(Blueprint $table)
                {
                    $table->increments('id');
                    $table->timestamps();
                    $table->string('_token');

                });

            }
        }
            $sistemas = Sistema::paginate();
        $user=Auth::user()->id;

        return view('admin.sistemas.index', compact('sistemas','user'));


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
