<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Input;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        if($_POST["inputs"]) {
            //dd($this->request->all());
            $inputs=$_POST["inputs"];
            //$inputs=\Illuminate\Support\Facades\Input::get('inputs');//Input es una palabra reservada de laravel, al igual que el nombre del modelo Input
            $decodedInput=json_decode($inputs, true);
            $inputs=$decodedInput['inputs'];

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
