<?php namespace App\Http\Controllers\Admin;

use App\Entrada;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Opcione;
use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;

class EntradasController extends Controller {


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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $newconnection= \Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);

        $data=$this->request->all();
        //dd($data);
        $entrada= new Entrada($data);
        $entrada->setConnection($newconnection);

        $tab=Tab::on($newconnection)->findOrFail($data['tab_id']);
        $tab->setConnection($newconnection);

        $entrada=$tab->entradas()->save($entrada);

        $input_name=$entrada->field_name;
        $input=$tab->id.'_'.$input_name;


        Schema::connection($newconnection)->table('inputs', function($table) use ($input)
        {
            $table->string($input);
        });

        if(Input::get('opcion_name') == "") {
            $opcion_name = array();
            $entrada->opciones()->sync($opcion_name);

        }else {

            foreach(Input::get('opcion_name') as $opcion) {

                $opcion=new Opcione(['option_name'=>$opcion]);

                $opcion->setConnection($newconnection);
                $entrada->opciones()->save($opcion);
            }
        }

        return redirect()->back();
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

}
