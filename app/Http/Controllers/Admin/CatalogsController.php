<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Entrada;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Opcione;
use App\Sistema;
use App\Tab;
use App\User;
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
            'description'=>'required'
        );
        $this->validate($this->request,$rules);

        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $data=$this->request->all();
        $catalog=new Catalog($data);
        $catalog->setConnection($newconnection)->save();
        $catalogtablename= $catalog->id."_".$newconnection;

        $tabs=$catalog->tabs;

        Schema::connection($newconnection)->create($catalogtablename, function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('respuesta');
            $table->timestamps();
            $table->string('_token');
            $table->integer('entrada_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('tablet_id')->unsigned();

            $table->foreign('entrada_id')
                ->references('id')
                ->on('entradas')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('tablet_id')
                ->references('id')
                ->on('tablets')
                ->onDelete('cascade');
        });

        return view('admin.catalogs.edit',compact('catalog','tabs'));
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

        foreach($tabs as $tab){
            $entradas[$tab->id]=Entrada::on($newconnection)->where('tab_id','=',$tab->id)->get();
            foreach($entradas[$tab->id] as $entrada){
                $opciones[$entrada->id]=Opcione::on($newconnection)->where('entrada_id','=',$entrada->id)->get();

            }
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


            return view('admin.catalogs.edit', compact('catalog', 'tabs', 'entradas'));
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
