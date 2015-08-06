<?php namespace App\Http\Controllers\Admin;

use App\Entrada;
use App\Entradatipo;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Opcione;
use App\Tab;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        //Guardar entradas con opciones dinamicas
        if($data['entradatipo_id']==9){
            $i=0;

            //Para cada campo seleccionado se crea una nueva entrada.
            $campoopcionarray=$data['campo_opcion'];
            foreach($campoopcionarray as $nuevaentrada) {
                //Se guarda la entrada principal, el id de esta entrada es el entradaprincipal_id e identifica el grupo
                // de entradas con opciones dinamicas, se asume que es el primero en el array
                if($i==0){
                    //No se carga directamente con $entrada = new Entrada($data); porque el $data['campo_opcion']
                    // es un array y laravel genera un error.
                    $data['campo_opcion']=$nuevaentrada;
                    $entrada = new Entrada($data);
                    $entrada->setConnection($newconnection);

                    //Se instancia el objeto Entradatipo seleccionado, tipoentrada hasMany Entrada
                    $entradatipo = Entradatipo::on($newconnection)->findOrFail($data['entradatipo_id']);
                    $entradatipo->setConnection($newconnection);

                    //Se instancia el objeto Tab al que pertenece la entrada, Tab hasMany Entrada
                    $tab = Tab::on($newconnection)->findOrFail($data['tab_id']);
                    $tab->setConnection($newconnection);

                    //Se hacen las asociaciones
                    $entrada->entradatipo()->associate($entradatipo);
                    $entrada->tab()->associate($tab);
                    $entrada->save();

                    //Se guarda la entrada principal, con base en la cual se precargan las otras entradas dinamicas. por
                    // ejemplo con el nombre cliente seleccionado se hacen las consultas para traer direccion y telefono.
                    $data['$entradaprincipal_id']=$entrada->id;
                    $entrada->entradaprincipal_id=$data['$entradaprincipal_id'];
                    $entrada->save();
                    $i=$i+1;

                }else {
                    //Se carga el nombre, descripcion y tipo de la nueva entrada que se genera con base en los campos seleccionados
                    $nuevaentradaname = Entrada::on($newconnection)->findOrFail($nuevaentrada)->field_name;
                    $nuevaentradadesc = Entrada::on($newconnection)->findOrFail($nuevaentrada)->field_description;
                    $nuevaentradatipo = Entrada::on($newconnection)->findOrFail($nuevaentrada)->entradatipo_id;

                    $entrada = new Entrada($data);
                    $entrada->field_name = $nuevaentradaname;
                    $entrada->field_description = $nuevaentradadesc;
                    $entrada->entradatipo_id = $nuevaentradatipo;
                    $entrada->campo_opcion = $nuevaentrada;
                    $entrada->entradaprincipal_id=$data['$entradaprincipal_id'];

                    $entrada->setConnection($newconnection);

                    //Se instancia el objeto Entradatipo seleccionado, tipoentrada hasMany Entrada
                    $entradatipo = Entradatipo::on($newconnection)->findOrFail($data['entradatipo_id']);
                    $entradatipo->setConnection($newconnection);

                    //Se instancia el objeto Tab al que pertenece la entrada, Tab hasMany Entrada
                    $tab = Tab::on($newconnection)->findOrFail($data['tab_id']);
                    $tab->setConnection($newconnection);

                    //Se hacen las asociaciones
                    $entrada->entradatipo()->associate($entradatipo);
                    $entrada->tab()->associate($tab);
                    $entrada->save();

                }

                DB::connection($newconnection)->table('entrada_opdinamicas')->insert(
                    [
                        'entrada_id' => $entrada->id,
                        'opdinamica_id' => $data['opdinamica_id'],
                        'campo_opcion' => $nuevaentrada,
                        'entradaprincipal_id' => $data['$entradaprincipal_id'],
                        'consulta' => $data['consulta']

                    ]
                );
            }

        }

        //Guardar entradas con opciones simples
        if( ($data['entradatipo_id']==3) || ($data['entradatipo_id']==4)){
            //Se instancia la nueva entrada
            $entrada= new Entrada($data);
            $entrada->setConnection($newconnection);

            //Se instancia el objeto Entradatipo seleccionado, tipoentrada hasMany Entrada
            $entradatipo=Entradatipo::on($newconnection)->findOrFail($data['entradatipo_id']);
            $entradatipo->setConnection($newconnection);

            //Se instancia el objeto Tab al que pertenece la entrada, Tab hasMany Entrada
            $tab=Tab::on($newconnection)->findOrFail($data['tab_id']);
            $tab->setConnection($newconnection);

            //Se hacen las asociaciones
            $entrada->entradatipo()->associate($entradatipo);
            $entrada->tab()->associate($tab);

            $entrada->save();

            foreach(Input::get('opcion_name') as $opcion) {
                $opcion = new Opcione(['option_name' => $opcion]);
                $opcion->setConnection($newconnection);
                $entrada->opciones()->save($opcion);
            }
        }

        //Guardar entradas sin opciones
        if(($data['entradatipo_id']!=3) && ($data['entradatipo_id']!=4) && ($data['entradatipo_id']!=9)){
            //Se instancia la nueva entrada
            $entrada= new Entrada($data);
            $entrada->setConnection($newconnection);

            //Se instancia el objeto Entradatipo seleccionado, tipoentrada hasMany Entrada
            $entradatipo=Entradatipo::on($newconnection)->findOrFail($data['entradatipo_id']);
            $entradatipo->setConnection($newconnection);

            //Se instancia el objeto Tab al que pertenece la entrada, Tab hasMany Entrada
            $tab=Tab::on($newconnection)->findOrFail($data['tab_id']);
            $tab->setConnection($newconnection);

            //Se hacen las asociaciones
            $entrada->entradatipo()->associate($entradatipo);
            $entrada->tab()->associate($tab);

            $entrada->save();
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
