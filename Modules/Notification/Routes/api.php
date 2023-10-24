<?php

use Dingo\Api\Routing\Router;
use Modules\Notification\Http\Controllers\Api\NotificationController;

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
    $api->group(['prefix' => 'notifications'], function (Router $api) {
        $api->get('/', [NotificationController::class, 'index']);
        $api->get('/send', [NotificationController::class, 'send']);
        $api->get('/{id}', [NotificationController::class, 'show']);
        $api->post('/', [NotificationController::class, 'store']);
        $api->put('/read', [NotificationController::class, 'updateAll']);
        $api->put('/{id}', [NotificationController::class, 'update']);
    });
});