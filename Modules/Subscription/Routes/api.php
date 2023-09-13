<?php

use Dingo\Api\Routing\Router;
use Modules\Subscription\Http\Controllers\Api\SubscriptionController;

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
    $api->group(['prefix' => 'subscriptions'], function (Router $api) {
        $api->get('/', [SubscriptionController::class, 'index']);
        $api->post('/', [SubscriptionController::class, 'store']);
        $api->get('/{id}', [SubscriptionController::class, 'show']);
    });
});