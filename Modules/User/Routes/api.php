<?php

use Dingo\Api\Routing\Router;
use Modules\User\Http\Controllers\Api\UserController;

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
    $api->get('/user/me', [UserController::class, 'me']);
    $api->post('/user/profile/{id}', [UserController::class, 'update']);
    $api->put('/user/password', [UserController::class, 'updatePassword']);
    $api->delete('/user/delete/{id}', [UserController::class, 'destroy']);
});
