<?php

namespace Microservice;

use Out;

class Auth extends Service
{
	static function login()
	{
		$email    = static::sanitize($_REQUEST["email"]);
		$password = static::sanitize($_REQUEST["password"]);

		$url = "http://authreg/login";
		$data = [
            "email"    => $email,
            "password" => $password,
        ];
        $options = [
            "http" => [
                "header"  => "Content-type: application/json",
                "method"  => "POST",
                "content" => json_encode($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

		var_dump($result);

		$auth = [
			"token"    => "pippo1",
			"userid"   => "pippo6",
			"username" => "pippo2",
			"name"     => "pippo3",
			"surname"  => "pippo4",
			"phone"    => "pippo5",
		];

		return $auth;
	}

	static function register()
	{
		$email    = static::sanitize($_REQUEST["email"]);
		$password = static::sanitize($_REQUEST["password"]);
		$username = static::sanitize($_REQUEST["username"]);
		$name     = static::sanitize($_REQUEST["name"]);
		$surname  = static::sanitize($_REQUEST["surname"]);
		$phone    = static::sanitize($_REQUEST["phone"]);

		//TODO

		if (false)
		{
			Out::send("ERROR", "Registration error");
		}

		$auth = [
			"token"    => "pippo1",
			"userid"   => "pippo6",
			"username" => "pippo2",
			"name"     => "pippo3",
			"surname"  => "pippo4",
			"phone"    => "pippo5",
		];

		return $auth;
	}

	static function get()
	{
		$token = static::sanitize($_REQUEST["token"]);

		if (!$token)
		{
			Out::send("UNLOGGED", "Token Missing. Please login");
		}

		//TODO

		$auth = [
			"token"    => "pippo1",
			"userid"   => "pippo6",
			"username" => "pippo2",
			"name"     => "pippo3",
			"surname"  => "pippo4",
			"phone"    => "pippo5",
		];

		return $auth;
	}

	static function logout()
	{
		$token = static::sanitize($_REQUEST["token"]);

		//TODO

		return [];
	}
}