<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSistemaRequest extends Request {

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
            'nombreDataBase'=>'required',
            'description'=>'required',
            'user_id'=>'required',
            //'logo_sistema'=>'required',
            //'imagen_fondo'=>'required'
		];
	}

}
