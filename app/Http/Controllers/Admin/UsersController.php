<?php namespace App\Http\Controllers\Admin;

use App\ClienteHasPlan;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;

use App\Plan;
use App\Sistema;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;



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
	public function store(CreateUserRequest $request)
	{

        $data=$this->request->all();

        $user = new User($data);
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

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user=User::find($id)->first();

        $sistemas=$user->sistema;
        $plans=Plan::all();


        return view('admin.users.edit',compact('user','plans','sistemas'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditUserRequest $request,$id)
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
        User::destroy($id);

        Session::flash('message','El registro fue eliminado');

        return redirect()->route('admin.users.index');

	}

}
