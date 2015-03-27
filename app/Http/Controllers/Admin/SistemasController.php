<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\User;
use Illuminate\Http\Request;

class SistemasController extends Controller {

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
		return view('admin.sistemas.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$sistema = new Sistema($this->request->all());

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user=User::findOrFail($id);
        $userid=$user->id;
        $sistema = new Sistema($this->request->all());
        $sistema->user_id=$userid;
        $sistema->save();

        $user=User::find($userid);
        $sistemas=$user->sistema;
        $plans=$user->plan;


        return view('admin.users.edit', compact('user','sistemas','plans'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

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
