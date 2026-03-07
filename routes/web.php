<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolInstitutionController;
use App\Http\Controllers\SchoolLevelController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PersonTypeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\ClassRoomStudentController;
use App\Http\Controllers\ClassRoomHomeroomTeacherController;
use App\Http\Controllers\TeacherSubjectAssignmentController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\IdCardController;
use App\Http\Controllers\Admin\MenuController;


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
    Route::resource('class-rooms', ClassRoomController::class, ['names' => 'class_rooms']);
    Route::resource('subjects', SubjectController::class, ['names' => 'subjects']);
    
    // Person Management Routes
    Route::resource('persons', PersonController::class, ['names' => 'persons']);
    Route::resource('person-types', PersonTypeController::class, ['names' => 'person_types']);
    Route::resource('students', StudentController::class, ['names' => 'students']);
    Route::resource('teachers', TeacherController::class, ['names' => 'teachers']);
    Route::resource('staffs', StaffController::class, ['names' => 'staffs']);
    
    // Relational Module Routes
    Route::resource('time-slots', TimeSlotController::class, ['names' => 'time_slots']);
    Route::resource('class-room-students', ClassRoomStudentController::class, ['names' => 'class_room_students']);
    Route::resource('class-room-homeroom-teachers', ClassRoomHomeroomTeacherController::class, ['names' => 'class_room_homeroom_teachers']);
    Route::resource('teacher-subject-assignments', TeacherSubjectAssignmentController::class, ['names' => 'teacher_subject_assignments']);
    Route::resource('class-schedules', ClassScheduleController::class, ['names' => 'class_schedules']);
    Route::get('class-schedules-grid', [ClassScheduleController::class, 'grid'])->name('class_schedules.grid');
    Route::resource('id-cards', IdCardController::class, ['names' => 'id_cards']);
    Route::get('id-cards/statistics', [IdCardController::class, 'statistics'])->name('id_cards.statistics');
    
    // Menu Management Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('menus', MenuController::class);
        
        // API endpoints for menu
        Route::get('menus-tree', [MenuController::class, 'getMenuTree'])->name('menus.tree');
        Route::get('menus-structure', [MenuController::class, 'getMenuStructure'])->name('menus.structure');
        Route::post('menus-reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    });
});


