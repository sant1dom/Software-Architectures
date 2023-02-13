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

$entities = [
    "bill" => ["index", "show"],
    "prediction" => ["index", "consumption", "production", "future"],
    "auth" => ["login", "register", "logout"],
    "dashboard" => ["index"]
];

foreach ($entities as $entity => $methods) {
    $controller = $prefix . ucfirst($entity) . 'Controller';
    foreach ($methods as $method) {
        Route::match("get", "$entity/$method", [$controller, $method])->name("$entity.$method");
        if ($entity === "auth") {
            Route::match("post", "$entity/$method", [$controller, "{$method}_send"])->name("$entity.$method" . "_send");
        }
    }
}

Route::get('/', function () {
    return redirect(route("bill.index"));
});

