<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\SchoolInstitutions\SchoolInstitutionController;

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

Route::middleware('auth.api.token')->group(function () {
    Route::middleware('validate.menu.permission')->group(function () {
        Route::prefix('school-institutions')->name('api.school_institutions.')->group(function () {
            // DataTable endpoint
            Route::get('/datatable', [SchoolInstitutionController::class, 'dataTable'])->name('datatable');

            // List with pagination and search
            Route::get('/', [SchoolInstitutionController::class, 'index'])->name('index');
            // CRUD operations
            Route::post('/', [SchoolInstitutionController::class, 'store'])->name('store');
            Route::get('/{school_institution}', [SchoolInstitutionController::class, 'show'])->name('show');
            Route::put('/{school_institution}', [SchoolInstitutionController::class, 'update'])->name('update');
            Route::delete('/{school_institution}', [SchoolInstitutionController::class, 'destroy'])->name('destroy');
        });
    });
});
