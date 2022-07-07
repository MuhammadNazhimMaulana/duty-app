<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\{ProfileController, AvatarController, LogController};
use App\Http\Controllers\Api\Admin\{ClassController};
use App\Http\Controllers\Api\Auth\AuthController;

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

// Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/confirm-reset-password', [AuthController::class, 'confirmResetPassword']);
});

// Need Login
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('/auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // User
    Route::prefix('/user')->group(function () {
        
        // Profile
        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'profile']);
            Route::post('/', [ProfileController::class, 'store']);
            Route::put('/', [ProfileController::class, 'update']);
        });

        // Avatar
        Route::prefix('/avatar')->group(function () {
            Route::get('/', [AvatarController::class, 'index']);
            Route::post('/', [AvatarController::class, 'store']);
            Route::put('/', [AvatarController::class, 'update']);
        });
        
        // Logs
        Route::prefix('/log')->group(function () {
            Route::get('/', [LogController::class, 'index']);
        });

        // Class
        Route::prefix('/class')->group(function () {
            Route::get('/', [ClassController::class, 'index']);
        });

    });

});
