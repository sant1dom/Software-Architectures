<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
	public function view($page, $data = [])
	{
		$route              = Route::currentRouteName();
		$ar                 = explode(".", $route);
		$controller         = $ar[0];
		$method             = $ar[1];
		$path               = "{$controller}/{$controller}_{$page}";
		$data["controller"] = $controller;
		$data["method"]     = $method;

		return view($path, $data);
	}
}
