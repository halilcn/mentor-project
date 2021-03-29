<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\EmailVerificationController;
use App\Http\Controllers\API\Auth\MeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(
    ['prefix' => '/v1'],
    function () {
        // ----- PUBLIC -----
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);

        Route::post('/email-verification-send', [EmailVerificationController::class, 'send']);
        Route::post('/email-verification-verify', [EmailVerificationController::class, 'verify']);


        // ----- AUTH -----
        Route::middleware('auth:sanctum')->group(
            function () {
                Route::get('/me', [MeController::class, 'index']);

                Route::post('/logout', [AuthController::class, 'logout']);
            }
        );
    }
);
