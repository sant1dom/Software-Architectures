<?php

namespace Microservice;

use Microservice\Auth;

class Prediction extends Service
{
	static function getConsumption()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $$auth["userid"];

		$url = "http://prediction:8085/getConsumption";
	    $fields = ["userid"];
		return static::send($url, $data);
	}

	static function getProduction()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $$auth["userid"];

		$url = "http://prediction:8085/getProduction";
	    $fields = ["userid"];
		return static::send($url, $data);
	}

	static function getFuture()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $$auth["userid"];

		$url = "http://prediction:8085/getFuture";
	    $fields = ["userid"];
		return static::send($url, $data);
	}
}