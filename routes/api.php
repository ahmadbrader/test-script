<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Epresence\EpresenceController;
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
Route::post('/signin', [AuthController::class, 'signIn']);

Route::group(['middleware' => ['api.spv']], function() {
    Route::get('user', [AuthController::class, 'getAllUser']);
    Route::post('epresence/response', [EpresenceController::class, 'responseEpresence']);
});

Route::group(['middleware' => ['api.all']], function() {
    Route::post('epresence', [EpresenceController::class, 'store']);
    Route::get('epresence/my', [EpresenceController::class, 'myData']);
});
