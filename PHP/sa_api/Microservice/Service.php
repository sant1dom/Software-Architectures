<?php
#require_once __DIR__ . '/../Out.php';
namespace Microservice;
use Out;

class Service
{
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
				$url .= $key . '=' . $value . '&';
			}
			$raw_response = file_get_contents($url);
		}

		$results = json_decode($raw_response);
		if (!is_object($results))
		{
			Out::send("ERROR", $raw_response);
		}

		return $results;
    }
}