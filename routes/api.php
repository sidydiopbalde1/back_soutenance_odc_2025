<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('campagnes')
    ->group(function () {
        Route::get('/',        [CampagneController::class, 'index']);
        Route::post('/',       [CampagneController::class, 'store']);
        Route::get('/{id}',    [CampagneController::class, 'show']);
        Route::put('/{id}',    [CampagneController::class, 'update']);
        Route::delete('/{id}', [CampagneController::class, 'destroy']);
});
Route::prefix('roles')
    ->group(function () {
        Route::get('/',        [RoleController::class, 'index']);
});
Route::get('/users',          [UserController::class, 'index']);
Route::post('/users',         [UserController::class,'store']);
// Route::prefix('users')
//      ->middleware(['auth:api','permission:view-users,create-users,edit-users,delete-users'])
//      ->group(function(){
//          Route::get('/restore',   [UserController::class, 'showUserRestored']);
//             Route::post('/',         [UserController::class,'store']);
//             Route::get('/{id}',      [UserController::class, 'show']);
//             Route::put('/{id}',      [UserController::class, 'update']);
//             Route::delete('/{id}',   [UserController::class, 'delete']);
//             Route::put('/restore/{id}',[UserController::class,'restoreUser']);
//             Route::post('/{id}/activate',[UserController::class, 'activeOrDesactiveUser']);
// });
        
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/logs', [LogController::class, 'index']);
});