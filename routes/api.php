<!-- use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

// 1. Authentication Routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

// 2. Protected Routes (Require JWT Token)
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Company Management (7.1)
    Route::prefix('companies')->group(function () {
        Route::post('/register', [CompanyController::class, 'register']); // Super Admin creates company
        Route::get('/', [CompanyController::class, 'index']);           // List all
        Route::get('/{id}', [CompanyController::class, 'show']);        // Get by ID
        Route::put('/{id}', [CompanyController::class, 'update']);      // Update
        Route::put('/{id}/toggle-status', [CompanyController::class, 'toggleStatus']);
    });

    // User Management (7.2)
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store']);             // Create User
        Route::get('/', [UserController::class, 'index']);              // List Users
        Route::put('/{id}', [UserController::class, 'update']);         // Update User
        Route::delete('/{id}', [UserController::class, 'destroy']);      // Delete User
        Route::put('/{id}/reset-password', [UserController::class, 'resetPassword']);
    });
}); -->

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Authentication ───────────────────────────────────────────────
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login',  [AuthController::class, 'login']);

// ─── Protected Routes ─────────────────────────────────────────────
Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 7.1 Company Management — Super Admin only
    Route::prefix('companies')->middleware('role:super_admin')->group(function () {
        Route::post('/',                  [CompanyController::class, 'register']);
        Route::get('/',                   [CompanyController::class, 'index']);
        Route::get('/{id}',               [CompanyController::class, 'show']);
        Route::put('/{id}',               [CompanyController::class, 'update']);
        Route::put('/{id}/toggle-status', [CompanyController::class, 'toggleStatus']);
    });

    // 7.2 User Management — Super Admin or Company Admin
    Route::prefix('users')->middleware('role:super_admin,company_admin')->group(function () {
        Route::post('/',                   [UserController::class, 'store']);
        Route::get('/',                    [UserController::class, 'index']);
        Route::put('/{id}',                [UserController::class, 'update']);
        Route::delete('/{id}',             [UserController::class, 'destroy']);
        Route::put('/{id}/reset-password', [UserController::class, 'resetPassword']);
    });

});