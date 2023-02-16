<?php
#require_once __DIR__ . '/../Out.php';
namespace Microservice;
use Out;

class Service
{
	public static function isDebug()
	{
		return (isset($_GET["debug"]) && $_GET["debug"]== "debug");
	}

	static function sanitize($string)
	{
		$string = str_replace("'",          "\\’",        $string);
		$string = str_replace('"',          '\\"',        $string);

		$string = str_replace('&',          '&amp;',    $string);
		$string = str_replace('"',          '&quot;',   $string);
		$string = str_replace('<',          '&lt;',     $string);
		$string = str_replace('>',          '&gt;',     $string);

		$string = str_replace('&amp;amp;',  '&amp;',    $string);
		$string = str_replace('&amp;quot;', '&quot;',   $string);
		$string = str_replace('&amp;lt;',   '&lt;',     $string);
		$string = str_replace('&amp;gt;',   '&gt;',     $string);

		$string = trim($string);

		return $string;
	}

	static function send($url, $data, $method = "get", $json = false)
    {
		if ($json)
		{
			$options      = [
				"http" => [
					"header"  => "Content-type: application/json",
					"method"  => $method,
					"content" => json_encode($data),
				],
			];
			$context      = stream_context_create($options);
			$raw_response = file_get_contents($url, false, $context);
		}
		else
		{
			foreach($data as $key => $value)
			{
				$url .= $key . "=" . urlencode($value) . '&';
			}
			$raw_response = file_get_contents($url);
		}

	    $response = json_decode($raw_response);

	    if (static::isDebug())
	    {
		    var_dump($url);
		    var_dump($raw_response);
		    var_dump($response);
	    }

		if (!is_object($response) && !is_array($response))
		{
			Out::send("ERROR", $raw_response);
		}

		return $response;
    }
}