<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GimmeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\RegistryController;
use App\Http\Controllers\RegistryRecordController;
use App\Http\Controllers\ServiceTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('token', [AuthController::class, 'token']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('payments', PaymentController::class);
Route::apiResource('payment-types', PaymentTypeController::class);
Route::middleware('auth:sanctum')->apiResource('providers', ProviderController::class);
Route::apiResource('registries', RegistryController::class);
Route::apiResource('registry-records', RegistryRecordController::class);
Route::apiResource('service-types', ServiceTypeController::class);

Route::middleware('auth:sanctum')->apiResource('gimme', GimmeController::class);