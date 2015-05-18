<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TabsController extends Controller {


    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        $this->request = $request;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

        return view('admin.catalogs.tabs.create',compact('catalog'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $data=$this->request->all();
        $catalogid=$data['catalog_id'];


        $rules=array(
            'name'=>'required',
            'description'=>'required'
        );
        $v=Validator::make($data, $rules);
        if($v->fails()){
            return redirect()->route('admin.catalogs.edit',compact('catalogid'))
                ->withErrors($v->errors())
                ->withInput($data);
        }

        $tab= new Tab($data);
        $tab->setConnection($newconnection);

        $catalog=Catalog::on($newconnection)->findOrFail($catalogid);
        $catalog->setConnection($newconnection)->tabs()->save($tab);
        return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        $tab=Tab::on($newconnection)->findOrFail($id);

        return view('admin.catalogs.tabs.edit', compact('tab','catalog'));
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

        $data=$this->request->all();

        $rules=array(
            'name'=>'required',
            'description'=>'required'
        );
        $v=Validator::make($data, $rules);
        if($v->fails()){
            return redirect()->route('admin.catalogs.edit',compact('catalogid'))
                ->withErrors($v->errors())
                ->withInput($data);
        }

        $tab=Tab::on($newconnection)->findOrFail($id);
        $tab->fill($data);
        $tab->save();

        $catalogid=$tab->catalog_id;

        return redirect()->route('admin.catalogs.edit',compact('catalogid'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        return $id;
        $newconnection= Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        $tab=Tab::on($newconnection)->findOrFail($id);
        $catalogid=$tab->catalog_id;
        $tab->delete();

        $message='La Ficha fue eliminada';

        if($this->request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);



        return redirect()->route('admin.catalogs.edit',compact('catalogid'));
	}

    public function tabcatalog($id)
    {
/*        $userid = Auth::user()->id;
        $user=User::findOrFail($userid);
        $sistemas=$user->sistemas;

        foreach($sistemas as $sistema) {
            $dbname = ($sistema->nombreDataBase) . '_' . $userid;
            $otf = new OnTheFly(['database'=>$dbname]);
            $otf2 = new Catalog(['database'=>$dbname]);
        }


        $tab = new Tab($this->request->all());
        //La ventaja de on() es que me permite consultar en una sola linea una nueva conexion, puedo hacerlo con setConnection pero debo crear primero un Object = new Object
        $catalog= Catalog::on($dbname)->findOrFail($id);

        $tab->setConnection($dbname);

        $tab=$catalog->tabs()->save($tab);*/


    }

}
