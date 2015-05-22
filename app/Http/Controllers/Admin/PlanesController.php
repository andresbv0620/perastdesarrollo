<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlanRequest;

use App\Http\Requests\EditPlanRequest;
use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PlanesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    protected $request;
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->request=$request;
    }
	public function index()
	{
        $plans=Plan::paginate();
        return view('admin.planes.index', compact('plans'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.planes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreatePlanRequest $request)
	{
		$plans= new Plan($this->request->all());
        $plans->save();
        return \Redirect::route('admin.planes.index');
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
		$plan=Plan::findOrFail($id);

        return view('admin.planes.edit', compact('plan'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditPlanRequest $request, $id)
	{
		$plan=Plan::findOrFail($id);
        $plan->fill($this->request->all());
        $plan->save();
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
        Plan::destroy($id);
        Session::flash('message','El registro fue eliminado');
        return redirect()->route('admin.planes.index');
	}

}
