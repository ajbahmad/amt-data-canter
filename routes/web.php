<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolInstitutionController;
use App\Http\Controllers\SchoolLevelController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\SubjectController;


require __DIR__.'/auth.php';

// Data Center Routes (authenticated users only)
Route::middleware(['auth'])->group(function () {
    // Admin Group Routes
    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');
    Route::resource('school-institutions', SchoolInstitutionController::class, ['names' => 'school_institutions']);
    Route::resource('school-levels', SchoolLevelController::class, ['names' => 'school_levels']);
    Route::resource('school-years', SchoolYearController::class, ['names' => 'school_years']);
    Route::resource('semesters', SemesterController::class, ['names' => 'semesters']);
    Route::resource('grades', GradeController::class, ['names' => 'grades']);
    Route::resource('class-rooms', ClassRoomController::class, ['names' => 'class-rooms']);
    Route::resource('subjects', SubjectController::class, ['names' => 'subjects']);
});

