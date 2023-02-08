<?php

namespace App\Models;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthRequestRegister extends FormRequest
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
			"password" => [
				'required',
				'confirmed',
				Password::defaults(),
			],
			//"password_confirmation" => "required",
			"name"     => "required",
			"surname"  => "required",
			"phone"    => "max:255",
		];
	}
}
