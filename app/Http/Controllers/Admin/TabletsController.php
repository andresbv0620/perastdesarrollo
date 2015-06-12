<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sistema;
use App\Tablet;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Input;
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
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Session::has('tenant_id')) {
            $sistema_id = Session::get('tenant_id');

            $tablets = Sistema::findOrFail($sistema_id)->tablets()->paginate();
            return view('admin.tablets.index', compact('tablets'));
        }else{
            Session::flash('message','Para registrar tablets antes debe seleccionar un sistema');
            return redirect(url('/home'));
        }

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(Session::has('tenant_id')) {
            $tenant_id=Session::get('tenant_id');
            $sistema=Sistema::findOrFail($tenant_id);
            $tablets=Tablet::all();
            $tabletscheckeds=$sistema->tablets()->lists('tablet_id');
            return view('admin.tablets.create',compact('tabletscheckeds','tablets'));
        }else{
            Session::flash('message','Para registrar tablets antes debe seleccionar un sistema');
            return redirect(url('/home'));
        }
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
        if((Input::get('tablet_id')=="")||($data['idUnicoTablet']!="")) {
            $rules = array(
                'idUnicoTablet' => 'required|unique:tablets,idUnicoTablet',
                'description' => 'required'
            );
            $this->validate($this->request, $rules);
            $tablet=new Tablet($data);
            $tablet->save();
            $tablet_id=$tablet->id;
            $sistema->tablets()->attach($tablet_id);
        }else{
            $sistema->tablets()->sync(Input::get('tablet_id'));
        }





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
        $tablet=Tablet::findOrFail($id);
        return view('admin.tablets.edit', compact('tablet'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Route $route)
	{
        $rules=array(
            'idUnicoTablet'=>'required|unique:tablets,idUnicoTablet,'.$route->getParameter('tablets'),
            'description'=>'required'
        );
        $this->validate($this->request,$rules);
        $tablet=Tablet::findOrFail($id);
        $tablet->fill($this->request->all());
        $tablet->save();
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
        Tablet::destroy($id);
        $message='El registro fue eliminado de nuestros registros';

        if($this->request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);
        return redirect()->route('admin.tablets.index');
	}

}
