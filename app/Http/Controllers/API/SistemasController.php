<?php namespace App\Http\Controllers\API;

use App\Catalog;
use App\Http\Requests;
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

class SistemasController extends Controller {

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        //$this->middleware('auth');
        $this->request = $request;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $sistemas=Sistema::paginate();
        return view('admin.sistemas.index', compact('sistemas'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $users=User::all();

        $usercheckeds = array();
		return view('admin.sistemas.create',compact('users','usercheckeds'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data=$this->request->all();
		$sistema = new Sistema($data);
        $sistema->save();

        if(Input::get('user_id')=="") {
            $user_id = array();
            $sistema->users()->sync($user_id);

        }else{
            $sistema->users()->sync(Input::get('user_id'));
            $users_id = Input::get('user_id');
            foreach($users_id as $userid) {
                $connection=array();
                $dbname = ($sistema->nombreDataBase) . '_' .$userid;
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
                    $table->string('name');
                    $table->string('description');
                    $table->string('value');
                    $table->boolean('esPrincipal')->default(true);
                    $table->integer('tab_id')->unsigned();
                    $table->timestamps();

                    $table->foreign('tab_id')
                        ->references('id')
                        ->on('tabs')
                        ->onDelete('cascade');
                });

            }
        }
            $sistemas = Sistema::paginate();

        return view('admin.sistemas.index', compact('sistemas'));


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

        // Get the users table
        $catalogs = $otf->getTable('catalogs');


        foreach ($catalogs as $catalog)
        {
            dd($catalog->name);
        }
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

        $data =$this-> request->all ();
        $sistema=Sistema::findOrFail($id);
        $sistema->fill($data);
        $sistema->save();

        $tablet = new Tablet($data);
        $tablet->save ();
        $tablet->sistemas()->attach($sistema);

        $sistema->users()->sync(Input::get('user_id'));


        $sistemas=Sistema::paginate();
        return view('admin.sistemas.index', compact('sistemas'));


    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
