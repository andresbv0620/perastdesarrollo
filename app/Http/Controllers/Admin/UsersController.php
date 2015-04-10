<?php namespace App\Http\Controllers\Admin;

use App\ClienteHasPlan;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Controllers\Controller;

use App\Plan;
use App\Role;
use App\Sistema;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $this->middleware('auth');
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
        $sistemas=Sistema::all();
        $roles=Role::all();
        $rolescheckeds=array();
        $sistemascheckeds=array();
		return view('admin.users.create', compact('plans','users','sistemas','roles','rolescheckeds','sistemascheckeds'));
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
        $user->roles()->sync(Input::get('role_id'));
        $user->sistemas()->sync(Input::get('sistema_id'));


        if($user->hasRole(['superadmin','admin'])) {
            $planid = $data['plan_id'];
            $plan = Plan::findOrFail($planid);
            $user->plans()->attach($plan);
        }



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
        $user=User::findOrFail($id);

        $sistemas=$user->sistemas;
        $plans=Plan::all();

        $rolescheckeds=$user->roles()->lists('role_id');
        $sistemascheckeds=$user->sistemas()->lists('sistema_id');

        $roles=Role::all();
        $sistemas=Sistema::all();
        $users=array();


        return view('admin.users.edit',compact('user','plans','sistemas','roles','users','rolescheckeds','sistemascheckeds'));
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

        $user->roles()->sync(Input::get('role_id'));
        $user->sistemas()->sync(Input::get('sistema_id'));
        $user->plans()->sync(Input::get('plan_id'));

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
