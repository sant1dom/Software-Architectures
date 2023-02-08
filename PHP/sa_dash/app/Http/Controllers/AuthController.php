<?php

namespace App\Http\Controllers;

use App\Models\ExceptionUnlogged;
use App\Models\ExceptionError;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Auth;
use App\Models\AuthRequestLogin;
use App\Models\AuthRequestRegister;

class AuthController extends Controller
{
	/**
	 * Login method
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function login(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if ($auth)
		{
			return redirect(route("bill.index"));
		}

		$data["auth"] = $auth;
		return $this->view("login", $data);
	}

	/**
	 * Login Post method
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function login_send(AuthRequestLogin $request)
	{
		try
		{
			$fields  = $request->validated();

			$email = $fields['email'];
			$password = $fields['password'];

			$auth = Auth::login($email, $password);

			$request->session()->put('auth', $auth);
			return redirect(route("bill.index"));
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
	}

	/**
	 * Register method
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function register(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if ($auth)
		{
			return redirect(route("bill.index"));
		}

		$data["auth"] = $auth;
		return $this->view("register", $data);
	}

	/**
	 * Register Post method
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function register_send(AuthRequestRegister $request)
	{
		try
		{
			$fields  = $request->validated();

			$email    = $fields['email'];
			$password = $fields['password'];
			$name     = $fields['name'];
			$surname  = $fields['surname'];
			$phone    = $fields['phone'];

			$auth = Auth::register($email, $password, $name, $surname, $phone);

			$request->session()->put('auth', $auth);
			return redirect(route("bill.index"));
		}
		catch(ExceptionUnlogged $e)
		{
			$request->session()->put('auth', null);
			return redirect(route("auth.register"));
		}
		catch(ExceptionError $e)
		{
			abort(500, $e->getMessage());
		}
	}

	/**
	 * Logout method
	 *
	 *  @param Request $request
	 * @return Response
	 */
	public function logout(Request $request)
	{
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

		if ($auth)
		{
			Auth::logout($auth->token);
			$request->session()->put('auth', null);
		}

		return redirect(route("auth.login"));
	}

}
