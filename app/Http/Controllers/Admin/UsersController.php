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
        //$this->middleware('auth');
        $this->request=$request;

    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
	{
        $data=$this->request;

        /** @var TYPE_NAME $users */
        $users=User::name($data->get('name'))->orderBy('id','DESC')->paginate();
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
        $systems=Sistema::all();
        $roles=Role::all();
        $rolescheckeds=array();
        $sistemascheckeds=array();
		return view('admin.users.create', compact('plans','users','systems','roles','rolescheckeds','sistemascheckeds'));
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

        if(Input::get('systems_id')=="") {
            $systems_id=array();
            $user->sistemas()->sync($systems_id);
        }else {

            $user->sistemas()->sync(Input::get('systems_id'));
        }


        $user->roles()->sync(Input::get('role_id'));

        if($user->hasRole(['superadmin','admin'])) {
            if(isset($plan_id)) {
                $planid = $data['plan_id'];
                $plan = Plan::findOrFail($planid);
                $user->plans()->attach($plan);
            }
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

        $systems=Sistema::all();
        $plans=Plan::all();
        $roles=Role::all();

        $rolescheckeds=$user->roles()->lists('role_id');
        $sistemascheckeds=$user->sistemas()->lists('sistema_id');

        $usercheckeds=array();



        return view('admin.users.edit',compact('user','plans','systems','roles','users','rolescheckeds','sistemascheckeds','usercheckeds'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditUserRequest $request,$id)
	{
        $data=$this->request->all();



        $user=User::findOrFail($id);
        $user->fill($data);
        $user->save();

        if(Input::get('systems_id')=="") {
            $systems_id=array();
            $user->sistemas()->sync($systems_id);
        }else {

            $user->sistemas()->sync(Input::get('systems_id'));
        }





        $user->roles()->sync(Input::get('role_id'));

        if(isset($plan_id)) {
            $user->plans()->sync(Input::get('plan_id'));
        }
        return redirect()->back();
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
	public function destroy($id)
	{
        //$this->user->delete();
        User::destroy($id);//Opcion

        $message='fue eliminado de nuestros registros';

        if($request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);

        return redirect()->route('admin.users.index');

	}

}
