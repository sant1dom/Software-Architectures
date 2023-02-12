<?php

namespace Microservice;

class Bill extends Service
{
	static function getAll()
	{
	    $data = [];

	    $auth   = Auth::get();
		$data["userid"] = $auth->userid;

		$url = "http://bills:8082/getAll?";

		return static::send($url, $data);
	}

	static function getId()
	{
	    $data = [];
	    $fields = ["billid"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[$field]);
		}

	    $auth   = Auth::get();
		$data["userid"] = $auth->userid;

		$url = "http://bills:8082/getId?";

		return static::send($url, $data);
	}
}