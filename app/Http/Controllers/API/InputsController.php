<?php namespace App\Http\Controllers\API;

use App\Catalog;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Input;
use App\Tablet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class InputsController extends Controller {

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
		$tablet_id=$this->request->input('tablet_id');
		$tablet=Tablet::findOrFail('001');
		$sistemas = $tablet->sistemas;
		$sistemasArray=array();
		foreach($sistemas as $sistema) {
			$newconnection=$sistema->nombre_db;
			$otf = new OnTheFly(['database' => $newconnection]);
			$catalogs = Catalog::on($newconnection)->get();
			$catalogosArray=array();
			foreach($catalogs as $catalog){
				$respuestas=DB::connection($newconnection)->table($catalog->id)->get();
				$respuestasArray=array();
				foreach($respuestas as $respuesta){
					$respuestasArray[]=array(
						'id'=>$respuesta->id,
						'respuesta'=>$respuesta->respuesta,
						'entrada_id'=>$respuesta->entrada_id,
						'respuestasgrupo_id'=>$respuesta->respuestasgrupo_id

					);
				}

				$catalogosArray[]=array(
					'catalogoId'=>$catalog->id,
					'catalogoNombre'=>$catalog->name,
					'catalogoDescripcion'=>$catalog->description,
					'catalogoTipo'=>$catalog->tipo,
					'respuestas'=>$respuestasArray
				);
			}

			$id=$sistema->id;
			$sistemasArray[]=array(
				'sistemaId'=>$id,
				'catalogos'=>$catalogosArray
			);
		}
		$response = array(
			'respuestas' => $sistemasArray,
		);
		return Response::json($response);
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
		$inputs = file_get_contents('php://input');

		if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/respuestas.txt")){
			$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/respuestas.txt","wb");
			fwrite($fp,$inputs);
			fclose($fp);
		}else{
			$myfile = file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/respuestas.txt", $inputs.PHP_EOL , FILE_APPEND);
		}

        if($inputs) {
			$obj = json_decode(utf8_encode($inputs));
			$idtablet=$obj->tablet_id;
			$newconnection=$obj->dbSistema;
			$sistemaid=$obj->sistemaId;
			$respuesta=$obj->respuesta;
			$iduser=$obj->usuarioId;
			$identrada=$obj->entradaId;
			$grupoentradaid=$obj->grupoEntrada;
			$tablerespuestas=$obj->catalogoId;

			//Se procesan las respuestas
			$otf = new OnTheFly(['database'=>$newconnection]);
			//$lastgroup=DB::connection($newconnection)->table($tablerespuestas)->orderby('respuestasgrupo_id','DESC')->take(1)->lists('respuestasgrupo_id');
			//$lastgroup=(int)$lastgroup[0];
			//$grupoid=DB::connection($newconnection)->table('respuestasgrupos')->insertGetId([]);

			if(is_array($respuesta)) {
				foreach ($respuesta as $opcionrespuesta) {
					DB::connection($newconnection)->table($tablerespuestas)->insert(
						[
							'_token' => 'token',
							'respuesta' => $opcionrespuesta,
							'entrada_id' => $identrada,
							'user_id' => $iduser,
							'tablet_id' => $idtablet,
							'catalog_id' => $tablerespuestas,
							'respuestasgrupo_id' => $grupoentradaid
						]
					);
				}
			}else{
				DB::connection($newconnection)->table($tablerespuestas)->insert(
					[
						'_token' => 'token',
						'respuesta' => $respuesta,
						'entrada_id' => $identrada,
						'user_id' => $iduser,
						'tablet_id' => $idtablet,
						'catalog_id' => $tablerespuestas,
						'respuestasgrupo_id' => $grupoentradaid
					]
				);
			}
			return "registro exitoso";
        }
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
