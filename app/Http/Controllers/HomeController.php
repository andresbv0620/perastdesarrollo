<?php namespace App\Http\Controllers;



use App\Sistema;
use App\User;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\Entrust;
use Zizaco\Entrust\EntrustFacade;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $userid=Auth::user()->id;
        $username=Auth::user()->name;



        $isuser=User::all()->first();
        if(!empty($isuser)) {
            if (EntrustFacade::hasRole('superadmin')) {
                $user = Auth::user()->id;
                $sistemas = Sistema::paginate();

            }elseif (EntrustFacade::hasRole('admin')) {
                $user = Auth::user()->id;
                $sistemas = User::findOrFail($user)->sistemas()->paginate();
            }

            if(EntrustFacade::hasRole(['superadmin','admin','recolector','reportes'])){
                return view('home', compact('sistemas','userid'));

            }else{
                $user=Auth::user()->id;
                return view('index.vars',compact('user','username'));
            }

        }else{
            Session::flash('message','Antes de empezar debe Registrar un usuario');
            return redirect()->route('admin.usuarios.index');
        }



        //
	}

}
