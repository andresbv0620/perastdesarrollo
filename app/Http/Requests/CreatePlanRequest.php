<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePlanRequest extends Request {

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
            'nombre'=>'required|unique:plans,nombre',
            'capacidad'=>'required|numeric',
            'cantidadTablets'=>'required|numeric',
            'sistemas'=>'required|numeric',
            'duracion'=>'required',
            'precio'=>'required|numeric',
            'periodicidad'=>'required|in:anual,mensual'
		];
	}

}
