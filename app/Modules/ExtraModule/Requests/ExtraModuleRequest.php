<?php
namespace App\Modules\ExtraModule\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\NotAuthorizedException;
use Input;
use Sentinel;

class ExtraModuleRequest extends FormRequest {

	public function authorize(){
		return true;
	}

	public function rules(){
        
		$rules = [
			'description' => 'required',
			'banner_img'  => 'required',
			'logo_img'    => 'required'
		];

		return $rules;
	}
}
