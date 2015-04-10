<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tablet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

class SistemasController extends Controller {

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request){

        $this->middleware('auth');
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
        $users=User::all();

        $usercheckeds = array();
		return view('admin.sistemas.create',compact('users','usercheckeds'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data=$this->request->all();
		$sistema = new Sistema($data);
        $sistema->save();

        $sistema->users()->sync(Input::get('user_id'));

        $sistemas=Sistema::paginate();
        return view('admin.sistemas.index',compact('sistemas'));


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
        $sistema=Sistema::findOrFail($id);
        $tablets=$sistema->tablets;
        $users=User::all();

        $usercheckeds = $sistema->users()->lists('user_id');


        return view('admin.sistemas.edit',compact('sistema','tablets','users','usercheckeds'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

        $data =$this-> request->all ();
        $sistema=Sistema::findOrFail($id);
        $sistema->fill($data);
        $sistema->save();

        $tablet = new Tablet($data);
        $tablet->save ();
        $tablet->sistemas()->attach($sistema);

        $sistema->users()->sync(Input::get('user_id'));


        $sistemas=Sistema::paginate();
        return view('admin.sistemas.index', compact('sistemas'));


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
