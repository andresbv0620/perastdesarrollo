<?php namespace App\Http\Controllers\Admin;

use App\Catalog;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tab;
use Illuminate\Http\Request;

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
        $tab = new Tab($this->request->all());
        $tab->catalog_id=$id;
        $tab->save();
        return redirect()->back();
    }

}
