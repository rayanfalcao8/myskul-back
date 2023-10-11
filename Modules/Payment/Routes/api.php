<?php

use Dingo\Api\Routing\Router;
use Modules\Payment\Http\Controllers\Api\PaymentController;

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

    $api->group(['prefix' => 'payment'], function (Router $api) {
        $api->post('/', [PaymentController::class, 'index']);
        $api->post('/callback', [PaymentController::class, 'callBack']);
        $api->get('/methods', [PaymentController::class, 'getMethods']);
        $api->get('/status/{trid}', [PaymentController::class, 'checkStatus']);
    });
});