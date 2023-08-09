<?php

use Dingo\Api\Routing\Router;
use Modules\Authentication\Http\Controllers\Api;
use Modules\Authentication\Http\Controllers\Api\Passport;
use Modules\Authentication\Http\Controllers\Api\Sanctum;

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

if (config('modules.core.api_connection') === 'sanctum') {
    $api->version('v1', function (Router $api) {
        $api->post('/login', [Sanctum\AuthenticateController::class, 'login']);
        $api->post('/register', [Sanctum\RegisterController::class, 'register']);

        /* Authenticated Routes */
        $api->group(['middleware' => 'auth:sanctum'], function (Router $api) {
            $api->post('logout', [Sanctum\AuthenticateController::class, 'logout']);
        });
    });
}

if (config('modules.core.api_connection') === 'passport') {
    $api->version('v1', function (Router $api) {
        $api->post('/login', [Passport\AuthenticateController::class, 'authenticate']);
        $api->post('/register', [Passport\RegistrationController::class, 'register']);

        /* Authenticated Routes */
        $api->group(['middleware' => 'auth:api'], function (Router $api) {
            $api->post('logout', [Passport\AuthenticateController::class, 'logout']);
        });
    });
}

$api->version('v1', function (Router $api) {
    $api->post('/forgot-password', [Api\ForgotPasswordController::class, 'forgot']);
    $api->post('/reset-password', [Api\ResetPasswordController::class, 'reset']);
});
