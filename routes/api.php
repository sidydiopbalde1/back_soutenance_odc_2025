<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('roles')
    ->group(function () {
        Route::get('/', [RoleController::class, 'index']);
    });
Route::prefix('campagnes')
    ->group(function () {
        Route::get('/', [CampagneController::class, 'index']);
        Route::get("/process-rewards", [CampagneController::class, 'processRewards']);
        Route::get("/ofTheDay", [CampagneController::class, 'campaignsOfTheDay']);
        Route::get('/match-transactions-campaigns', [CampagneController::class, 'matchTransactionsWithCampaigns']);
        Route::post('/', [CampagneController::class, 'store']);
        Route::get('/{id}', [CampagneController::class, 'show']);
        Route::put('/{id}', [CampagneController::class, 'update']);
        Route::delete('/{id}', [CampagneController::class, 'destroy']);
    });

Route::prefix('users')->middleware(['auth:api', 'permission:view-users,create-users,edit-users,delete-users'])
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
        Route::put('/restore/{id}', [UserController::class, 'restoreUser']);
        Route::get('/restore', [UserController::class, 'showUserRestored']);
        Route::get('/deleted', [UserController::class, 'showUserDeleted']);
        Route::put('/restore/{id}', [UserController::class, 'restoreUser']);
        Route::post('/{id}/activate', [UserController::class, 'activeOrDesactiveUser']);
    });

Route::post('login', [AuthController::class, 'login']);
Route::post('change-password', [AuthController::class, 'changePassword']);


Route::prefix('services')->middleware(['auth:api'])
    ->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'store']);
        Route::get('/{id}', [ServiceController::class, 'show']);
        Route::put('/{id}', [ServiceController::class, 'update']);
        Route::delete('/{id}', [ServiceController::class, 'destroy']);
        Route::post('/restore/{id}', [ServiceController::class, 'restore']);
    });

Route::prefix('logs')->middleware(['auth:api'])
    ->group(function () {
        Route::get('/', [LogController::class, 'index']);
    });


Route::prefix('transactions')
    ->group(function () {
        Route::post('/transfert/{id}', [TransactionController::class, 'transferTransaction']);
        Route::post('/creditCharge/{id}', [TransactionController::class, 'creditChargeTransaction']);
        Route::post('/billPaiment/{id}', [TransactionController::class, 'billPaiementTransaction']);
        Route::get("/unrewared", [TransactionController::class, 'getTransactionsOfTheDay']);
        Route::get("/process-reward", [TransactionController::class, 'processRewards']);
    });