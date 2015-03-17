<?php namespace App\Http\Controllers\Admin;

use App\ClienteHasPlan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Plan;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    protected $request;

    public function __construct(Request $request){
        $this->request=$request;

    }

	public function index()
	{
		$users=User::paginate();
        return view('admin.users.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $plans=Plan::all();
        $users=User::all();
		return view('admin.users.create', compact('plans','users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $user = new User($this->request->all());
        $user->save();

        $insertedId=$user->id;

        $clientehasplan=new ClienteHasPlan($this->request->all());
        $clientehasplan->cliente_id=$insertedId;
        $clientehasplan->save();

        return \Redirect::route('admin.users.index');
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
        $user=User::findOrFail($id);
        $plans=Plan::all();
		return view('admin.users.edit',compact('user','plans'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $user=User::findOrFail($id);
        $user->fill($this->request->all());
        $user->save();

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
		//
	}

}
