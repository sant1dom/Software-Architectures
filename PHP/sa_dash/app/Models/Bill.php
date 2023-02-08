<?php

namespace App\Models;

class Bill extends Model
{
	public static function getAll($token)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
		];

		$bills = static::sendRequest($request);

		return $bills;
	}

	public static function getId($token, $id)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
			"id"     => $id,
		];

		$bill = static::sendRequest($request);

		return $bill;
	}
}
