<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\ExceptionError;
use App\Models\ExceptionUnlogged;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Bill;

class BillController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
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
			$data["bills"] = Bill::getAll($auth->token);
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
		return $this->view("index", $data);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function show(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if (!$auth)
		{
			return redirect(route("auth.login"));
		}

		$id = $_REQUEST['id'];

		if ($id == "")
		{
			return redirect(route("bill.index"));
		}

		try
		{
			$data["bill"] = Bill::getId($auth->token, $id);
		}
		catch(Exception $e)
		{
			if ($e->getCode() == "UNLOGGED")
			{
				$request->session()->put('auth', null);
				return redirect(route("auth.login"));
			}
			else
			{
				die($e->getMessage());
			}
		}

		$data["auth"] = $auth;
		return $this->view("show", $data);
	}
}
