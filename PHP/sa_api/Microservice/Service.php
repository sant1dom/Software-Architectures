<?php

namespace Microservice;

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
}