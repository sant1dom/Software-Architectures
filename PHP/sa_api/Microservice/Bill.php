<?php

namespace Microservice;
use Out;

class Bill extends Service
{
	static function getAll()
	{
		//no need to check the validity of $auth, because the Auth::get method always return a valid user or dies
		$auth   = Auth::get();
		$userid = $auth["userid"];

		//TODO
		$url = "http://bills:8082/bills?userid=" . $userid;
		$raw_response = file_get_contents($url);

		$bills = json_decode($raw_response);
		if (!is_array($bills))
		{
			Out::send("ERROR", "", $raw_response);
		}

		return $bills;
	}

	static function getId()
	{
		//no need to check the validity of $auth, because the Auth::get method always return a valid user or dies
		$auth   = Auth::get();
		$userid = $auth["userid"];

		$id = static::sanitize($_REQUEST["id"]);

		//TODO
		$url = "http://bills:8082/bills?userid=" . $userid;
		$raw_response = file_get_contents($url);

		$bills = json_decode($raw_response);
		if (!is_array($bills))
		{
			Out::send("ERROR", "", $raw_response);
		}

		foreach($bills as $bill)
		{
			if($bill->id == $id)
			{
				return $bill;
			}
		}

		return null;
	}
}