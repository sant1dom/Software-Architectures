<?php

namespace App\Models;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequestLogin extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			"email"    => "email|required",
			"password" => "required",
		];
	}
}
