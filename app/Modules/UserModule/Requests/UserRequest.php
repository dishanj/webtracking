<?php
namespace App\Modules\UserModule\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\NotAuthorizedException;
use Input;
use Sentinel;

class UserRequest extends FormRequest {

	public function authorize(){
		return true;
	}

	public function rules(){
        
		$rules = [
			'user_name' => 'required|e-mail|unique:users,email',
			'password' => 'required',
			'password_confirm' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'user_role' => 'required',
		];

		if($_REQUEST['user_role'] == 3){
			$rules['merchant'] = 'required';
		}
		return $rules;

	}
}
