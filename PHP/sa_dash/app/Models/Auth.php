<?php

namespace App\Models;

class Auth extends Model
{
	static $current = null;

	public static function login($email, $password)
	{
		$request = [
			"model"    => str_replace("App\\Models\\", "", get_class()),
			"method"   => __FUNCTION__,
			"email"    => $email,
			"password" => $password,
		];

		static::$current = static::sendRequest($request);

		return static::$current;
	}

	public static function register($email, $password, $username, $name, $surname, $phone)
	{
		$request = [
			"model"    => str_replace("App\\Models\\", "", get_class()),
			"method"   => __FUNCTION__,
			"email"    => $email,
			"password" => $password,
			"username" => $username,
			"name"     => $name,
			"surname"  => $surname,
			"phone"    => $phone,
		];

		static::$current = static::sendRequest($request);

		return static::$current;
	}

	public static function logout($token)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
		];

		static::sendRequest($request);

		static::$current = null;

		return true;
	}
}