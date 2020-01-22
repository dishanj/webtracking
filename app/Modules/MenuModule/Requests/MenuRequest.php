<?php
namespace App\Modules\MenuModule\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\NotAuthorizedException;
use Input;
use Sentinel;

class MenuRequest extends FormRequest {

	public function authorize(){
		return true;
	}

	public function rules(){
        
		$rules = [
			'labels' => 'required',
			'menu_url' => 'required',
			'permission' => 'required',
		];

		return $rules;
	}
}
