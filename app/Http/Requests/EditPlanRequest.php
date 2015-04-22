<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class EditPlanRequest extends Request {

    /**
     * @var Route
     */
    private $route;

    public function __construct(Route $route){

        $this->route = $route;
    }

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
            'nombre'=>'required|unique:plans,nombre,'.$this->route->getParameter('planes'),
            'capacidad'=>'required|numeric',
            'cantidadTablets'=>'required|numeric',
            'sistemas'=>'required|numeric',
            'duracion'=>'required',
            'precio'=>'required|numeric',
            'periodicidad'=>'required|in:anual,mensual'
        ];
	}

}
