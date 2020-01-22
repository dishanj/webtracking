<?php
namespace App\Modules\PermissionModule\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\NotAuthorizedException;
use Input;
use Sentinel;

class PermissionRequest extends FormRequest {

	public function authorize(){
		return true;
	}

	public function rules(){
        
		$rules = [
			'permission' => 'required',
		];

		return $rules;
	}
}
