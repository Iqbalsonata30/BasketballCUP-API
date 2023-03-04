<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/teams', App\Http\Controllers\Api\TeamController::class);

Route::apiResource('/players', App\Http\Controllers\Api\PlayerController::class)->except('show');
Route::prefix('players')->controller(App\Http\Controllers\Api\PlayerController::class)->group(function () {
    Route::get('/{slug}', 'show')->name('players.show');
});

Route::prefix('standings')->controller(App\Http\Controllers\Api\StandingController::class)->group(function () {
    Route::get('/', 'index')->name('standings.index');
    Route::put('/{id}', 'changePool')->name('change.pool');
});

Route::apiResource('/schedules', App\Http\Controllers\Api\ScheduleController::class)->except(['show', 'update']);
Route::prefix('schedules')->controller(App\Http\Controllers\Api\ScheduleController::class)->group(function () {
    Route::get('/{slug}', 'show')->name('schedules.show');
});
