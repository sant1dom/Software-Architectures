<?php

namespace Microservice;
use Out;

class Bill extends Service
{
	static function getAll()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $auth["userid"];

		$url = "http://bills:8082/getAll";
	    $fields = ["userid"];
		return static::send($url, $data);
	}

	static function getId()
	{
	    $data = [];
	    $fields = ["billid"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[field]);
		}

	    $auth   = Auth::get();
		$data["userid"] = $auth["userid"];

		$url = "http://bills:8082/getId";
	    $fields = ["userid"];
		return static::send($url, $data);
	}

	static function makeRandom()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $auth["userid"];

		$url = "http://bills:8082/makeRandom";
	    $fields = ["userid"];
		return static::send($url, $data);
	}
}