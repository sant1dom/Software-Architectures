<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    // Programmatically get the orgID from the InfluxDB API
    // This is required for the InfluxDB 2.0 API because it is not possible to use a single id for multiple orgs
    public function getOrgID(){
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Authorization: Token my-super-secret-auth-token',
                    'Accept: application/json',
                    'Content-Type: application/json'
                ]
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents(' http://influxdb:8086/api/v2/orgs', false, $context);

        $decoded_response = json_decode($response, true);

        $orgs = $decoded_response['orgs'];
        if (count($orgs) > 0) {
            $org_id = $orgs[0]['id'];
            return $org_id;
        } else {
            // handle the case where no orgs are returned
            return null;
        }

    }

	public function index(Request $request)
	{
		$data = [];
		$auth = $request->session()->get('auth');
		Auth::$current = $auth;

        // If the user is not logged in, redirect to the login page
		if (!$auth)
		{
			return redirect(route("auth.login"));
		}


        // Get the houses ids from the InfluxDB API
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
        $response = file_get_contents('http://influxdb:8086/api/v2/query?orgID=' . $this->getOrgID(), false, $context);

        // Parse the response extracting the house ids
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
