<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\ExceptionError;
use App\Models\ExceptionUnlogged;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Prediction;

class PredictionController extends Controller
{
	public function index(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if (!$auth)
		{
			return redirect(route("auth.login"));
		}

		$data["auth"] = $auth;
		return $this->view("index", $data);
	}

	/**
	 * Display the Predicition about the Consumption 
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function consumption(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if (!$auth)
		{
			return redirect(route("auth.login"));
		}

		try
		{
			$data["prediction"] = Prediction::getConsumption($auth->token);
		}
		catch(Exception $e)
		{
			if ($e->getCode() == "UNLOGGED")
			{
				return redirect(route("auth.login"));
			}
			else
			{
				die($e->getMessage());
			}
		}

		$data["auth"] = $auth;
		return $this->view("consumption", $data);
	}

	/**
	 * Display the Predicition about the Production
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function production(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if (!$auth)
		{
			return redirect(route("auth.login"));
		}

		try
		{
			$data["prediction"] = Prediction::getProduction($auth->token);
		}
		catch(Exception $e)
		{
			if ($e->getCode() == "UNLOGGED")
			{
				return redirect(route("auth.login"));
			}
			else
			{
				die($e->getMessage());
			}
		}

		$data["auth"] = $auth;
		return $this->view("production", $data);
	}

	/**
	 * Display the Predicition about the next future Bill
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function future(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if (!$auth)
		{
			return redirect(route("auth.login"));
		}

		try
		{
			$data["prediction"] = Prediction::getFuture($auth->token);
		}
		catch(ExceptionUnlogged $e)
		{
			$request->session()->put('auth', null);
			return redirect(route("auth.login"));
		}
		catch(ExceptionError $e)
		{
			abort(500, $e->getMessage());
		}

		$data["auth"] = $auth;
		return $this->view("future", $data);
	}
	
}
