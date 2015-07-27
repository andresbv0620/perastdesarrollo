<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Entrada;
use App\Entradatipo;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Opcione;
use App\Sistema;
use App\Tab;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class CatalogsController extends Controller {
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        $this->request = $request;
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Session::has('tenant_id')) {
           $newconnection = \Session::get('tenant_connection');
            $otf = new OnTheFly(['database' => $newconnection]);
            $catalogs = Catalog::on($newconnection)->paginate();
            return view('admin.catalogs.index', compact('catalogs'));
        }else{
            Session::flash('message','Antes debe seleccionar un sistema');
            return redirect()->route('admin.sistemas.index');
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        $tabs=Tab::on($newconnection);
        $catalogs=Catalog::on($newconnection);
        return view('admin.catalogs.create',compact('tabs','catalogs'));
	}

        /**
         * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $rules=array(
            'name'=>'required',
            'description'=>'required',
            'tipo'=>'required'
        );
        $this->validate($this->request,$rules);

        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $data=$this->request->all();
        $catalog=new Catalog($data);
        $catalog->setConnection($newconnection)->save();
        $catalogtablename= $catalog->id;

        $tabs=$catalog->tabs;

        ///paso las opciones de entrada, el id no se pasa porque las validaciones se hicieron con tipo_entrada
        $entradatipos = Entradatipo::on($newconnection)->lists('display_tipo_entrada','tipo_entrada');

        //Esta variable contiene los catalogos disponibles para que el usuario escoga de donde
        //cargar las opciones dinamicas (respuestas de catalogos).
        $tablaopciones = Catalog::on($newconnection)->lists('name','id');

        ///Cada catalogo tiene una tabla de respuestas cuyo nombre es el id del catalogo
        Schema::connection($newconnection)->create($catalogtablename, function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('respuesta');
            $table->timestamps();
            $table->string('_token');
            $table->integer('entrada_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('tablet_id')->unsigned();
            $table->integer('catalog_id')->unsigned();

            $table->foreign('entrada_id')
                ->references('id')
                ->on('entradas')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('perast_cliente.users')
                ->onDelete('cascade');
            $table->foreign('tablet_id')
                ->references('id')
                ->on('perast_cliente.tablets')
                ->onDelete('cascade');
            $table->foreign('catalog_id')
                ->references('id')
                ->on('catalogs')
                ->onDelete('cascade');
        });

        return view('admin.catalogs.edit',compact('catalog','tabs','entradatipos','tablaopciones'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $catalog=Catalog::on($newconnection)->findOrFail($id);

        $tabs=Tab::on($newconnection)->where('catalog_id','=',$id)->get();
        $entradas=array();
        $opciones=array();
        foreach($tabs as $tab){
            $entradas[$tab->id]=Entrada::on($newconnection)->where('tab_id','=',$tab->id)->get();
            foreach($entradas[$tab->id] as $entrada){
                $opciones[$entrada->id]=Opcione::on($newconnection)->where('entrada_id','=',$entrada->id)->get();
            }
        }

        if($this->request->ajax()){
            return response()->json($entradas);
        }

        return view('admin.catalogs.show',compact('catalog','tabs','entradas','opciones'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(Session::has('tenant_connection')) {
            $newconnection = \Session::get('tenant_connection');
            $otf = new OnTheFly(['database' => $newconnection]);

            $catalog = Catalog::on($newconnection)->findOrFail($id);

            $tabs = Tab::on($newconnection)->where('catalog_id', '=', $id)->get();

            foreach ($tabs as $tab) {
                $entradas[$tab->id] = Entrada::on($newconnection)->where('tab_id', '=', $tab->id)->get();
            }
            ///paso las opciones de entrada, el id no se pasa porque las validaciones se hicieron con tipo_entrada
            $entradatipos = Entradatipo::on($newconnection)->lists('display_tipo_entrada','id');

            //Esta variable contiene los catalogos disponibles para que el usuario escoga de donde
            //cargar las opciones dinamicas (respuestas de catalogos).
            $tablaopciones = Catalog::on($newconnection)->lists('name','id');

            return view('admin.catalogs.edit', compact('catalog', 'tabs', 'entradas', 'entradatipos', 'tablaopciones'));

        }else{
            Session::flash('message','Seleccine un sistema');
            return new RedirectResponse(url('/home'));
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        $rules=array(
            'name'=>'required',
            'description'=>'required'
        );
        $this->validate($this->request,$rules);
        $data=$this->request->all();
        $catalog=Catalog::on($newconnection)->findOrFail($id);
        $catalog->fill($data);
        $catalog->save();
        return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        Catalog::on($newconnection)->findOrFail($id)->delete();
        $message='El catálogo fue eliminado de nuestros registros';

        if($this->request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);
        return redirect()->route('admin.catalogs.index');
	}
}
