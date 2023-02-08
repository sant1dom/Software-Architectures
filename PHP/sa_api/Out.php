<?php

class Out
{
	static function send($code = "OK", $message = "", $results = [])
	{
		$response = [
			"code"    => $code,
			"message" => $message,
			"results" => $results,
		];

		die(json_encode($response));
	}
}