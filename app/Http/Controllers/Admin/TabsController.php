<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
	public function store($id)
	{

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
		//
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
        $data=$this->request->all();

        $tab= new Tab($data);

        $catalog=Catalog::findOrFail($id);
        $catalog->tabs()->save($tab);



        //$tab->catalog_id=$id;
        //$tab->save();
        return redirect()->back();
    }

}
