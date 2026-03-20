<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

// Auth routes
Route::prefix('auth')->group(function () {
    // Public routes - require API client validation
    Route::get('test', function () {
        return response()->json(['message' => 'Test endpoint']);
    });
    
    Route::middleware('validate.api.client')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // Protected routes - require valid API token
    Route::middleware('auth.api.token')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
    });
});
