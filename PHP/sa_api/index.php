<?php

error_reporting(E_ERROR | E_PARSE);

include_once("Out.php");

include_once("Microservice/Service.php");
include_once("Microservice/Auth.php");
include_once("Microservice/Bill.php");
include_once("Microservice/Prediction.php");

use Microservice\Service;

$model  = Service::sanitize($_REQUEST["model"]);
$method = Service::sanitize($_REQUEST["method"]);

$valids = [
	"Auth"       => [
		"login",
		"register",
		"get",
		"logout",
	],
	"Bill"       => [
		"getAll",
		"getId",
		"makeRandom",
	],
	"Prediction" => [
		"getConsumption",
		"getProduction",
		"getFuture",
	],
];

if (!in_array($model, array_keys($valids)))
{
	Out::send("ERROR", "Please choose a valid model");
}

if (!in_array($method, $valids[$model]))
{
	Out::send("ERROR", "Please choose a valid method for model $model");
}

$class = "Microservice\\" . $model;
$results = $class::$method();
Out::send("OK", "", $results);
