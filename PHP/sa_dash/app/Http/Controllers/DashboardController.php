<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
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

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Authorization: Token my-super-secret-auth-token',
                    'Accept: application/csv',
                    'Content-Type: application/vnd.flux'
                ],
                'content' => 'import "influxdata/influxdb/schema" schema.tagValues(bucket: "houses", tag: "house_id") |> yield()'
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents('http://influxdb:8086/api/v2/query?orgID=426f80826412bc54', false, $context);

        $lines = explode("\n", $response);
        $values = array_map(function ($line) {
            $parts = explode(",", $line);
            if (count($parts) > 1)
            {
                if (is_numeric($parts[3]))
                {
                    return $parts[3];
                }
            }
        }, $lines);
        $values = array_filter($values, function ($value) {
            return !empty($value);
        });

        $data["houses"] = $values;
		$data["auth"] = $auth;
		return $this->view("index", $data);
	}
}
