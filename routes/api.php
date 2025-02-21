<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


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

Route::prefix('users')->middleware(['auth:api','permission:view-users,create-users,edit-users,delete-users'])
    ->group(function(){
        Route::get('/',          [UserController::class, 'index']);
        Route::post('/',         [UserController::class,'store']);
        Route::put('/{id}',      [UserController::class, 'update']);
        Route::delete('/{id}',   [UserController::class, 'delete']);
        Route::put('/restore/{id}',[UserController::class,'restoreUser']);
        Route::get('/restore',   [UserController::class, 'showUserRestored']);
        Route::get('/deleted',   [UserController::class, 'showUserDeleted']);
        Route::put('/restore/{id}',[UserController::class,'restoreUser']);
        Route::post('/{id}/activate',[UserController::class, 'activeOrDesactiveUser']);
});
        
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->put('change-password', [AuthController::class, 'changePassword']);


Route::prefix('services')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::post('/', [ServiceController::class, 'store']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::put('/{id}', [ServiceController::class, 'update']);
    Route::delete('/{id}', [ServiceController::class, 'destroy']);
    Route::post('/restore/{id}', [ServiceController::class, 'restore']);
});