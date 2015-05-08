<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Entrada;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Opcione;
use App\Sistema;
use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogsController extends Controller {
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        $this->request = $request;
        //$this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
       /* $userid = Auth::user()->id;
        $user=User::findOrFail($userid);
        $sistemas=$user->sistemas;

        foreach($sistemas as $sistema){
            $dbname = ($sistema->nombreDataBase) . '_' .$userid;
            $otf = new OnTheFly(['database'=>$dbname]);
            $catalogs = Catalog::on($dbname)->findOrFail(1)->paginate();
        }*/

        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $catalogs=Catalog::on($newconnection)->paginate();



        return view('admin.catalogs.index', compact('catalogs'));
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
        /*$userid = Auth::user()->id;
        $user=User::findOrFail($userid);
        $sistemas=$user->sistemas;

        foreach($sistemas as $sistema) {
            $dbname = ($sistema->nombreDataBase) . '_' . $userid;
            $otf = new OnTheFly(['database'=>$dbname]);
            $otf2 = new Catalog(['database'=>$dbname]);
        }

		$data=$this->request->all();
        $catalog = new Catalog($data);
        $catalog->setConnection($dbname);
        $catalog->save();

        $tabs=$catalog->tabs;*/

        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $data=$this->request->all();

        $catalog=new Catalog($data);

        $catalog->setConnection($newconnection)->save();


        $tabs=$catalog->tabs;

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
        /*$userid = Auth::user()->id;
        $user=User::findOrFail($userid);
        $sistemas=$user->sistemas;

        foreach($sistemas as $sistema) {
            $dbname = ($sistema->nombreDataBase) . '_' . $userid;
            $otf = new OnTheFly(['database'=>$dbname]);
            $otf2 = new Catalog(['database'=>$dbname]);
        }

        //Otra forma de hacer la conexion en eloquent sin necesidad de usar on() que solo sirve para consultar, este me permitió consultar y guardar.

        $catalog=new Catalog();
        $catalog=$catalog->setConnection($dbname)->findOrFail($id);

        $tabs = DB::connection($dbname)->select('select * from tabs where catalog_id = ?', $id);*/

        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $catalog=Catalog::on($newconnection)->findOrFail($id);

        $tabs=Tab::on($newconnection)->where('catalog_id','=',$id)->get();

        foreach($tabs as $tab){
            $entradas=[$tab->id=>Entrada::on($newconnection)->where('tab_id','=',$tab->id)->get()];
        }

		return view('admin.catalogs.edit', compact('catalog','tabs','entradas'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
