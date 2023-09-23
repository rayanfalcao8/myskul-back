<?php

use Dingo\Api\Routing\Router;
use Modules\Product\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'auth:sanctum'], function (Router $api) {
    $api->group(['prefix' => 'products'], function (Router $api) {
        $api->get('/', [ProductController::class, 'index']);
        $api->get('/{id}', [ProductController::class, 'show']);
        $api->post('/', [ProductController::class, 'store']);
    });
});