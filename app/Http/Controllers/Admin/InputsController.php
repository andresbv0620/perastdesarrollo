<?php namespace App\Http\Controllers\Admin;

use App\Entrada;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Input;
use App\Tab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Zizaco\Entrust\EntrustFacade;

class InputsController extends Controller {

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
        $sistemadb=\Session::get('tenant_connection');
        $data=$this->request->all();

        $tablerespuestas=$data['idcatalogo'];
        $grupoid=DB::connection($newconnection)->table($tablerespuestas)->orderby('respuestasgrupo_id','DESC')->take(1)->lists('respuestasgrupo_id');

        if(empty($grupoid)){
            $grupoid=1;
        }else{
            $grupoid=$grupoid[0]+1;
        }

        $iduser=Auth::user()->id;
        ////En web este valor es irrelevante, y por lo tanto se usa un tablet_id=1////
        $idtablet=1;
        $tablerespuestas=$data['idcatalogo'];
        foreach($data['respuesta'] as $identrada => $respuesta){

            if(is_array($respuesta)) {
                foreach ($respuesta as $opcionrespuesta) {

                    DB::connection($newconnection)->table($tablerespuestas)->insert(
                        [
                            '_token' => $data['_token'],
                            'respuesta' => $opcionrespuesta,
                            'entrada_id' => $identrada,
                            'user_id' => $iduser,
                            'tablet_id' => $idtablet,
                            'catalog_id' => $tablerespuestas,
                            'respuestasgrupo_id' => $grupoid
                        ]
                    );
                }
            }else{
                DB::connection($newconnection)->table($tablerespuestas)->insert(
                    [
                        '_token' => $data['_token'],
                        'respuesta' => $respuesta,
                        'entrada_id' => $identrada,
                        'user_id' => $iduser,
                        'tablet_id' => $idtablet,
                        'catalog_id' => $tablerespuestas,
                        'respuestasgrupo_id' => $grupoid
                    ]
                );
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
        $tablarespuestas=$id;
        $sistema_id = Session::get('tenant_id');
        $sistema_db = Session::get('tenant_connection');
        $otf = new OnTheFly(['database'=>$sistema_db]);


        $entradarespuestas=DB::connection($sistema_db)->table($tablarespuestas)->get();
        //$subtable= DB::connection($sistema_db)->select('SELECT distinct `respuestasgrupo_id` FROM `1`');

        //Traigo los nombres de los campos
        $entradascampoid= DB::connection($sistema_db)->select('SELECT distinct `entrada_id` FROM `'.$tablarespuestas.'`');
        foreach($entradascampoid as $entradacampoid){
            $entrada=Entrada::on($sistema_db)->where('id','=',$entradacampoid->entrada_id)->first();
            $entradacampoid->nombrecampo=$entrada->field_name;
        }


        $users = DB::table('users')->distinct()->get();

        foreach($entradarespuestas as $entradarespuesta){
            $idgrupo=$entradarespuesta->respuestasgrupo_id;
            $respuestasgrupo=DB::connection($sistema_db)->table($tablarespuestas)->where('respuestasgrupo_id',$idgrupo)->get();
            foreach($respuestasgrupo as $respuestagrupo ){
                $entradas=Entrada::on($sistema_db)->where('id','=',$respuestagrupo->entrada_id)->first();
                $campo=$entradas->field_name;
                $tipo=$entradas->entradatipo_id;
                $respuestagrupo->campo=$campo;
                $respuestagrupo->tipo=$tipo;
            }
            $respuestasgrupoarray[$idgrupo]=$respuestasgrupo;
        }




        if(!empty($entradarespuestas)) {

            return view('admin.inputs.index', compact('respuestasgrupoarray','entradascampoid'));
        }else{
            Session::flash('message','No hay respuestas para este sistema');
            return redirect()->route('admin.sistemas.index');

        }

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
