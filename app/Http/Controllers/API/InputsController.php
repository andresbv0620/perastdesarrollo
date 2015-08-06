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
        if($inputs) {
			$obj = json_decode(utf8_encode($inputs));
			$tabletid=$obj->catalogoId;


            //dd($this->request->all());
            //$inputs=$_POST["respuestas"];

			//if($_POST["users"]){
			//$decode=json_decode($webhookContent, true);
			//$useremail=$decode[0]['$properties']['$email'];
			//$useremail2=$decode[1]['$properties']['$email'];
			//////////////Test the webhook in a file//////////////////////

			$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/tablet_id.txt","wb");
			fwrite($fp,$tabletid);
			fclose($fp);

			dd($inputs);




			//$inputs=\Illuminate\Support\Facades\Input::get('inputs');//Input es una palabra reservada de laravel,
            // al igual que el nombre del modelo Input
            $decodedInput=json_decode($inputs, true);
            $inputs=$decodedInput['respuestas'];


            foreach($inputs as $input) {
                $dbSistema=$input['dbSistema'];
                $otf = new OnTheFly(['database' => $dbSistema]);

                $entradas=$input['inputs'];
                foreach($entradas as $entrada) {
                    $entrada = array_except($entrada, array('id'));
                    Model::unguard();
                    $inputObject = new Input($entrada);
                    $inputObject->setConnection($dbSistema)->save();
                }
            }
            return "Guardado";
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
