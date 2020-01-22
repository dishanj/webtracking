<?php
namespace App\Modules\RoleModule\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\NotAuthorizedException;
use Input;
use Sentinel;

class RoleRequest extends FormRequest {

	public function authorize(){
		return true;
	}

	public function rules(){
        
		$rules = [
			'role_name' => 'required',
			'permission' => 'required'
		];

		return $rules;
	}
}
