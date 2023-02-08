<?php

namespace Microservice;

use Out;

class Auth extends Service
{
	static function login()
	{
	    $url = "http://authreg:8081/login";

	    $data = [];
	    $fields = ["email", "password"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[field]);
		}

		return static::send($url, $data);
	}

	static function register()
	{
	    $url = "http://authreg:8081/register?";

	    $data = [];
	    $fields = ["email", "password", "name", "surname", "phone"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[field]);
		}

		return static::send($url, $data);
	}

	static function get()
	{
		$url = "http://authreg:8081/get?";

	    $data = [];
	    $fields = ["token"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[field]);
		}

		return static::send($url, $data);
	}

	static function logout()
	{
		$url = "http://authreg:8081/logout?";

	    $data = [];
	    $fields = ["token"];
	    foreach ($fields as $field)
		{
		    $data[$field] = static::sanitize($_REQUEST[field]);
		}

		return static::send($url, $data);
	}
}