<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tablet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TabletsController extends Controller {

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
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
		$sistema_id=Session::get('tenant_id');

        $tablets=Sistema::findOrFail($sistema_id)->tablets()->paginate();
        return view('admin.tablets.index', compact('tablets'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.tablets.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $sistema_id=Session::get('tenant_id');
        $sistema=Sistema::findOrFail($sistema_id);

		$data=$this->request->all();
        $tablet=new Tablet($data);
        $tablet->save();
        $tablet_id=$tablet->id;


        $sistema->tablets()->attach($tablet_id);
        return \Redirect::route('admin.tablets.index');
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

}
