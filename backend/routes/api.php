<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    // Rotas públicas
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Rotas protegidas
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Rotas protegidas
Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resources([
        'travel-orders' => TravelOrderController::class
    ]);
    Route::get('/users', [UserController::class, 'index']);

    Route::patch('/travel-orders/{travelOrder}/status', [TravelOrderController::class, 'updateStatus'])->middleware('can:updateStatus,travelOrder');
    Route::patch('/travel-orders/{travelOrder}/cancel', [TravelOrderController::class, 'cancelTravelOrder'])->middleware('can:updateStatus,travelOrder');
});
