<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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
        $userid = Auth::user()->id;
        $user=User::findOrFail($userid);
        $sistemas=$user->sistemas;

        foreach($sistemas as $sistema){
            $dbname = ($sistema->nombreDataBase) . '_' .$userid;
            $otf = new OnTheFly(['database'=>$dbname]);
            $catalogs = Catalog::on($dbname)->findOrFail(1)->paginate();
        }



        return view('admin.catalogs.index', compact('catalogs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $tabs=Tab::all();
        $catalogs=Catalog::all();
        return view('admin.catalogs.create',compact('tabs','catalogs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $userid = Auth::user()->id;
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

        $tabs=$catalog->tab;
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

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $catalog=Catalog::find($id);
        $tabs=$catalog->tab;

		return view('admin.catalogs.edit', compact('catalog','tabs'));
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
