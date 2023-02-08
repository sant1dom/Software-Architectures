<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefix = "App\Http\Controllers\\";

$entity = "bill";
$controller = $prefix . ucfirst($entity) . 'Controller';

$r = Route::match("get", $entity . '/', [$controller, "index"]);
$r->name("$entity.index");

$r = Route::match("get", $entity . '/show', [$controller, "show"]);
$r->name("$entity.show");

Route::get('/', function () {
	return redirect(route("bill.index"));
});

$entity = "prediction";
$controller = $prefix . ucfirst($entity) . 'Controller';

$methods = [
	"index",
	"consumption",
	"production",
	"future",
];

foreach($methods as $method)
{
	$r = Route::match("get", $entity . '/' . $method, [$controller, $method]);
	$r->name("$entity.$method");
}



$entity = "auth";
$controller = $prefix . ucfirst($entity) . 'Controller';

$methods = [
	"login",
	"register",
	"logout",
];

foreach($methods as $method)
{
	$r = Route::match("get", $entity . '/' . $method, [$controller, $method]);
	$r->name("$entity.$method");

	$r = Route::match("post", $entity . '/' . $method, [$controller, $method . "_send"]);
	$r->name("$entity.$method" . "_send");
}