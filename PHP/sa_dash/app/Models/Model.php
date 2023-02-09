<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	public static function isDebug()
	{
		return (isset($_GET["debug"]) && $_GET["debug"]== "debug");
	}

	public static function sendRequest($request)
	{
		$url = "http://api_gateway/index.php?";

		foreach ($request as $k => $v)
		{
			$url .= $k . "=" . $v . '&';
		}

		$raw_response = file_get_contents($url);

		$response = json_decode($raw_response);
		if (static::isDebug())
		{
			dump($request);
			dump($raw_response);
			dump($response);
		}

		if (!is_object($response) && !is_array($response))
		{
			if (is_string($raw_response))
			{
				if (static::isDebug()) die("Line: " . __LINE__);
				throw new ExceptionError($raw_response);
			}

			if (static::isDebug()) die("Line: " . __LINE__);
			throw new ExceptionError("Connection with API error");
		}

		if ($response->code == "UNLOGGED")
		{
			if (static::isDebug()) die("Line: " . __LINE__);
			throw new ExceptionUnlogged($response->message);
		}

		if ($response->code != "OK")
		{
			if (static::isDebug()) die("Line: " . __LINE__);
			throw new ExceptionError($response->message);
		}

		return $response->results;
	}

	public function getUrlShow()
	{
		$c = $this->getClassName();
		return route($c . '.show', $this->getKey());
	}

	public function getClassName()
	{
		$path = explode('\\', get_called_class());
		return strtolower($path[count($path) - 1]);
	}

}
