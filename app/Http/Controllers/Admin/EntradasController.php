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
use Illuminate\Support\Facades\Session;

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
        $entrada= new Entrada($data);
        $entrada->setConnection($newconnection);

        $tab=Tab::on($newconnection)->findOrFail($data['tab_id']);
        $tab->setConnection($newconnection);

        $entrada=$tab->entradas()->save($entrada);


        //Se crean los campos para la tabla inputs que guardará las respuestas
        $input=$tab->id.'_'.$entrada->id;
        Schema::connection($newconnection)->table('inputs', function($table) use ($input)
        {
            $table->string($input);
        });



        if(Input::get('opcion_name') == "") {
            $opcion_name = array();
            $entrada->opciones()->sync($opcion_name);

        }else {

            foreach(Input::get('opcion_name') as $opcion) {
                if( ($data['field_type']=='opcion_multiple') || ($data['field_type']=='opcion_unica')) {
                    $opcion = new Opcione(['option_name' => $opcion]);
                    $opcion->setConnection($newconnection);
                    $entrada->opciones()->save($opcion);
                }
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

        $newconnection= Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$newconnection]);
        $entrada=Entrada::on($newconnection)->findOrFail($id);

        $entrada->setConnection($newconnection);
        $tabid=$entrada->tab_id;
        $entrada->setConnection($newconnection)->delete();


        $tab=Tab::on($newconnection)->findOrFail($tabid);
        $tab->setConnection($newconnection);
        $catalogid=$tab->catalog_id;

        $input=$tabid."_".$id;



        Schema::connection($newconnection)->table('inputs', function($table) use ($input)
        {
            $table->dropColumn($input);
        });
        $message='La Entrada fue eliminada';


        if($this->request->ajax()){
            return response()->json([
                'id'=>$id,
                'message'=>$message
            ]);
        }
        Session::flash('message',$message);

        return redirect()->route('admin.catalogs.edit',compact('catalogid'));
	}

}
