<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\{ProfileController, AvatarController, LogController, SubmissionController};
use App\Http\Controllers\Api\Admin\{ClassController, TaskController, ScoreController};
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
            Route::get('/pdf', [LogController::class, 'listPdf']);
        });

        // Class
        Route::prefix('/class')->group(function () {
            Route::get('/', [ClassController::class, 'index']);
            Route::post('/', [ClassController::class, 'store']);
            Route::get('/{id}', [ClassController::class, 'show']);
            Route::put('/{id}', [ClassController::class, 'update']);
            Route::delete('/{id}', [ClassController::class, 'delete']);
        });

        // Task
        Route::prefix('/task')->group(function () {
            Route::get('/', [TaskController::class, 'index']);
            Route::post('/', [TaskController::class, 'store']);
            Route::get('/{id}', [TaskController::class, 'show']);
            Route::put('/{id}', [TaskController::class, 'update']);
            Route::delete('/{id}', [TaskController::class, 'delete']);
        });

        // Task
        Route::prefix('/submission')->group(function () {
            Route::get('/', [SubmissionController::class, 'index']);
            Route::post('/', [SubmissionController::class, 'store']);
            Route::get('/{id}', [SubmissionController::class, 'show']);
            Route::put('/{id}', [SubmissionController::class, 'update']);
            Route::delete('/{id}', [SubmissionController::class, 'delete']);
        });

        // Score
        Route::prefix('/score')->group(function () {
            Route::get('/', [ScoreController::class, 'index']);
            Route::post('/', [ScoreController::class, 'store']);
            Route::get('/{id}', [ScoreController::class, 'show']);
            Route::put('/{id}', [ScoreController::class, 'update']);
            Route::delete('/{id}', [ScoreController::class, 'delete']);
        });

    });

});
