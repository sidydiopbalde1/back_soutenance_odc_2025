<?php

use App\Http\Controllers\CampagneController;
use App\Http\Middleware\FormatResponseMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([FormatResponseMiddleware::class])
    ->prefix('campagnes')
    ->group(function () {
        Route::get('/',        [CampagneController::class, 'index']);
        Route::post('/',       [CampagneController::class, 'store']);
        Route::get('/{id}',    [CampagneController::class, 'show']);
        Route::put('/{id}',    [CampagneController::class, 'update']);
        Route::delete('/{id}', [CampagneController::class, 'destroy']);
    });
