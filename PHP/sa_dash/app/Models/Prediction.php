<?php

namespace App\Models;

class Prediction extends Model
{
	public static function getConsumption($token)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
		];

		$prediction = static::sendRequest($request);

		return $prediction;
	}

	public static function getProduction($token)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
		];

		$prediction = static::sendRequest($request);

		return $prediction;
	}

	public static function getFuture($token)
	{
		$request = [
			"model"  => str_replace("App\\Models\\", "", get_class()),
			"method" => __FUNCTION__,
			"token"  => $token,
		];

		$prediction = static::sendRequest($request);

		return $prediction;
	}
}
