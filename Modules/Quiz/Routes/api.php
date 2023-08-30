<?php

use Dingo\Api\Routing\Router;
use Modules\Quiz\Http\Controllers\Api\ThemeController;

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
    $api->group(['prefix' => 'themes'], function (Router $api) {
        $api->get('/', [ThemeController::class, 'index']);
        $api->get('/level', [ThemeController::class, 'getByLevel']);
        $api->get('/speciality', [ThemeController::class, 'getByLevelAndSpeciality']);
        $api->get('/{id}', [ThemeController::class, 'show']);
    });
});