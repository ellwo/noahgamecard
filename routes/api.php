<?php

use App\Http\Controllers\Admin\UploadeController;
use App\Http\Controllers\PaymentmethodController;
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


Route::post('/uploade_prov_image', [UploadeController::class, 'uploade_prov']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

