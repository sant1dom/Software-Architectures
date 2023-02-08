<?php

namespace Microservice;

use Out;
use Microservice\Auth;

class Prediction extends Service
{
	static function getConsumption()
	{
		//no need to check the validity of $auth, because the Auth::get method always return a valid user or dies
		$auth   = Auth::get();
		$userid = $auth["userid"];

		//TODO

		$prediction = [
			"info1" => 1,
			"info2" => 2,
		];

		return $prediction;
	}

	static function getProduction()
	{
		//no need to check the validity of $auth, because the Auth::get method always return a valid user or dies
		$auth   = Auth::get();
		$userid = $auth["userid"];

		//TODO

		$prediction = [
			"info1" => 1,
			"info2" => 2,
		];

		return $prediction;
	}

	static function getFuture()
	{
		//no need to check the validity of $auth, because the Auth::get method always return a valid user or dies
		$auth   = Auth::get();
		$userid = $auth["userid"];

		//TODO

		$prediction = [
			"info1" => 1,
			"info2" => 2,
		];

		return $prediction;
	}
}