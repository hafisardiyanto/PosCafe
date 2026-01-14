<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// IMPORT CONTROLLER (WAJIB)
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\MenuApprovalController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Optional: cek user login
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    /*
    |--------------------------------------------------------------------------
    | KASIR
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:kasir')->group(function () {
        Route::post('/menu', [ProductController::class, 'store']); // ajukan menu
        Route::post('/transaction', [TransactionController::class, 'store']);
        Route::post('/shift/start', [ShiftController::class, 'start']);
        Route::post('/shift/{id}/end', [ShiftController::class, 'end']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN & MANAGER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/menu/pending', [MenuApprovalController::class, 'pending']);
        Route::post('/menu/{id}/approve', [MenuApprovalController::class, 'approve']);
        Route::post('/menu/{id}/reject', [MenuApprovalController::class, 'reject']);
    });

    /*
    |--------------------------------------------------------------------------
    | SEMUA ROLE (LOGIN)
    |--------------------------------------------------------------------------
    */
    Route::get('/menu/approved', [ProductController::class, 'approved']);
});
