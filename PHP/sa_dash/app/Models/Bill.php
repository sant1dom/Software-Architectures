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

	public static function getId($token, $billid)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
			"billid" => $billid,
		];

		$bill = static::sendRequest($request);

		return $bill;
	}
}
