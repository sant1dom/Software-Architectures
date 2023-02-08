<?php

namespace Microservice;

use Out;

class Auth extends Service
{
	static function login()
	{
	    $url = "http://authreg:8081/login";
	    $fields = ["email", "password"];
		return static::send($url, $fields);
	}

	static function register()
	{
	    $url = "http://authreg:8081/register?";
	    $fields = ["email", "password", "name", "surname", "phone"];
		return static::send($url, $fields);
	}

	static function get()
	{
		$url = "http://authreg:8081/get?";
	    $fields = ["token"];
		return static::send($url, $fields);
	}

	static function logout()
	{
		$url = "http://authreg:8081/logout?";
	    $fields = ["token"];
		return static::send($url, $fields);
	}
}