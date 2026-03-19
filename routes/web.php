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
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SchedulePatternController;
use App\Http\Controllers\SchoolDayScheduleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


require __DIR__ . '/auth.php';

// Data Center Routes (authenticated users only)
Route::middleware(['auth', 'auth.menu', 'auth.role'])->group(function () {
    // Admin Group Routes
    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // School Management Routes
    // Route::prefix('school-institutions')->name('school_institutions.')->group(function () {
    //     Route::get('/', [SchoolInstitutionController::class, 'index'])->name('index');
    //     Route::get('/create', [SchoolInstitutionController::class, 'create'])->name('create');
    //     Route::post('/', [SchoolInstitutionController::class, 'store'])->name('store');
    //     Route::get('/{school_institution}', [SchoolInstitutionController::class, 'show'])->name('show');
    //     Route::get('/{school_institution}/edit', [SchoolInstitutionController::class, 'edit'])->name('edit');
    //     Route::put('/{school_institution}', [SchoolInstitutionController::class, 'update'])->name('update');
    //     Route::delete('/{school_institution}', [SchoolInstitutionController::class, 'destroy'])->name('destroy');
    // });

    // // Route::resource('school-institutions', SchoolInstitutionController::class, ['names' => 'school_institutions']);
    // Route::resource('school-levels', SchoolLevelController::class, ['names' => 'school_levels']);
    // Route::resource('school-years', SchoolYearController::class, ['names' => 'school_years']);
    // Route::resource('semesters', SemesterController::class, ['names' => 'semesters']);
    // Route::resource('grades', GradeController::class, ['names' => 'grades']);
    // Route::get('class-rooms/set-schedule', [ClassRoomController::class, 'setSchedule'])->name('class_rooms.set_schedule');
    // Route::post('class-rooms/set-schedule', [ClassRoomController::class, 'updateSchedule'])->name('class_rooms.update_schedule');
    // Route::resource('class-rooms', ClassRoomController::class, ['names' => 'class_rooms']);
    // Route::resource('subjects', SubjectController::class, ['names' => 'subjects']);

    // // Person Management Routes
    // Route::resource('persons', PersonController::class, ['names' => 'persons']);
    // Route::resource('person-types', PersonTypeController::class, ['names' => 'person_types']);
    // Route::resource('students', StudentController::class, ['names' => 'students']);
    // Route::resource('teachers', TeacherController::class, ['names' => 'teachers']);
    // Route::resource('staffs', StaffController::class, ['names' => 'staffs']);

    // // Relational Module Routes
    // Route::resource('time-slots', TimeSlotController::class, ['names' => 'time_slots']);
    // Route::resource('class-room-students', ClassRoomStudentController::class, ['names' => 'class_room_students']);
    // Route::resource('class-room-homeroom-teachers', ClassRoomHomeroomTeacherController::class, ['names' => 'class_room_homeroom_teachers']);
    // Route::resource('teacher-subject-assignments', TeacherSubjectAssignmentController::class, ['names' => 'teacher_subject_assignments']);
    // Route::resource('class-schedules', ClassScheduleController::class, ['names' => 'class_schedules']);
    // Route::get('class-schedules-grid', [ClassScheduleController::class, 'grid'])->name('class_schedules.grid');
    // Route::resource('id-cards', IdCardController::class, ['names' => 'id_cards']);
    // Route::get('id-cards/statistics', [IdCardController::class, 'statistics'])->name('id_cards.statistics');

    // // Schedule Management Routes
    // Route::resource('schedule-patterns', SchedulePatternController::class);
    // Route::get('school-day-schedules', [SchoolDayScheduleController::class, 'index'])->name('school-day-schedules.index');
    // Route::get('school-day-schedules/{schedule}', [SchoolDayScheduleController::class, 'show'])->name('school-day-schedules.show');
    // Route::get('school-day-schedules/{schedule}/edit', [SchoolDayScheduleController::class, 'edit'])->name('school-day-schedules.edit');
    // Route::put('school-day-schedules/{schedule}', [SchoolDayScheduleController::class, 'update'])->name('school-day-schedules.update');

    // // Calendar Routes
    // Route::prefix('calendars')->name('calendars.')->group(function () {
    //     Route::get('/', [CalendarController::class, 'index'])->name('index');
    //     Route::get('/grid', [CalendarController::class, 'grid'])->name('grid');
    //     Route::get('events', [CalendarController::class, 'events'])->name('events');
    //     Route::post('/', [CalendarController::class, 'store'])->name('store');
    //     Route::get('/{calendar}/show', [CalendarController::class, 'show'])->name('show');
    //     Route::put('/{calendar}', [CalendarController::class, 'update'])->name('update');
    //     Route::delete('/{calendar}', [CalendarController::class, 'destroy'])->name('destroy');
    // });

    // Route::resource('applications', ApplicationController::class, ['names' => 'applications']);
    // Route::resource('roles', RoleController::class, ['names' => 'roles']);

    // // Menu Management Routes
    // Route::prefix('admin')->name('admin.')->group(function () {
    //     Route::resource('menus', MenuController::class);

    //     // API endpoints for menu
    //     Route::get('menus-tree', [MenuController::class, 'getMenuTree'])->name('menus.tree');
    //     Route::get('menus-structure', [MenuController::class, 'getMenuStructure'])->name('menus.structure');
    //     Route::post('menus-reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    //     Route::post('menus-update-permissions', [MenuController::class, 'updatePermissions'])->name('menus.update_permissions');
    // });


    // =========================================================================
    // Academic & Institution
    // =========================================================================

    Route::prefix('school-institutions')->name('school_institutions.')->group(function () {
        Route::get('/', [SchoolInstitutionController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SchoolInstitutionController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SchoolInstitutionController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{school_institution}', [SchoolInstitutionController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{school_institution}/edit', [SchoolInstitutionController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{school_institution}', [SchoolInstitutionController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{school_institution}', [SchoolInstitutionController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('school-levels')->name('school_levels.')->group(function () {
        Route::get('/', [SchoolLevelController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SchoolLevelController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SchoolLevelController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{school_level}', [SchoolLevelController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{school_level}/edit', [SchoolLevelController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{school_level}', [SchoolLevelController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{school_level}', [SchoolLevelController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('school-years')->name('school_years.')->group(function () {
        Route::get('/', [SchoolYearController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SchoolYearController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SchoolYearController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{school_year}', [SchoolYearController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{school_year}/edit', [SchoolYearController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{school_year}', [SchoolYearController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{school_year}', [SchoolYearController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('semesters')->name('semesters.')->group(function () {
        Route::get('/', [SemesterController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SemesterController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SemesterController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{semester}', [SemesterController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{semester}/edit', [SemesterController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{semester}', [SemesterController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{semester}', [SemesterController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('grades')->name('grades.')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [GradeController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [GradeController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{grade}', [GradeController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{grade}/edit', [GradeController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{grade}', [GradeController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{grade}', [GradeController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('class-rooms')->name('class_rooms.')->group(function () {
        Route::get('/set-schedule', [ClassRoomController::class, 'setSchedule'])->name('set_schedule')->defaults('label','can_view');
        Route::post('/set-schedule', [ClassRoomController::class, 'updateSchedule'])->name('update_schedule')->defaults('label','can_edit');
        Route::get('/', [ClassRoomController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [ClassRoomController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [ClassRoomController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{class_room}', [ClassRoomController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{class_room}/edit', [ClassRoomController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{class_room}', [ClassRoomController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{class_room}', [ClassRoomController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('subjects')->name('subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SubjectController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SubjectController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{subject}', [SubjectController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{subject}/edit', [SubjectController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{subject}', [SubjectController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    // =========================================================================
    // Person Management
    // =========================================================================

    Route::prefix('persons')->name('persons.')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [PersonController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [PersonController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{person}', [PersonController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{person}/edit', [PersonController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{person}', [PersonController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{person}', [PersonController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('person-types')->name('person_types.')->group(function () {
        Route::get('/', [PersonTypeController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [PersonTypeController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [PersonTypeController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{person_type}', [PersonTypeController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{person_type}/edit', [PersonTypeController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{person_type}', [PersonTypeController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{person_type}', [PersonTypeController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [StudentController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [StudentController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [TeacherController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [TeacherController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('staffs')->name('staffs.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [StaffController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [StaffController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    // =========================================================================
    // Relational Modules
    // =========================================================================

    Route::prefix('time-slots')->name('time_slots.')->group(function () {
        Route::get('/', [TimeSlotController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [TimeSlotController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [TimeSlotController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{time_slot}', [TimeSlotController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{time_slot}/edit', [TimeSlotController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{time_slot}', [TimeSlotController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{time_slot}', [TimeSlotController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('class-room-students')->name('class_room_students.')->group(function () {
        Route::get('/', [ClassRoomStudentController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [ClassRoomStudentController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [ClassRoomStudentController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{class_room_student}', [ClassRoomStudentController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{class_room_student}/edit', [ClassRoomStudentController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{class_room_student}', [ClassRoomStudentController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{class_room_student}', [ClassRoomStudentController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('class-room-homeroom-teachers')->name('class_room_homeroom_teachers.')->group(function () {
        Route::get('/', [ClassRoomHomeroomTeacherController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [ClassRoomHomeroomTeacherController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [ClassRoomHomeroomTeacherController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{class_room_homeroom_teacher}', [ClassRoomHomeroomTeacherController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{class_room_homeroom_teacher}/edit', [ClassRoomHomeroomTeacherController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{class_room_homeroom_teacher}', [ClassRoomHomeroomTeacherController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{class_room_homeroom_teacher}', [ClassRoomHomeroomTeacherController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('teacher-subject-assignments')->name('teacher_subject_assignments.')->group(function () {
        Route::get('/', [TeacherSubjectAssignmentController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [TeacherSubjectAssignmentController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [TeacherSubjectAssignmentController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{teacher_subject_assignment}', [TeacherSubjectAssignmentController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{teacher_subject_assignment}/edit', [TeacherSubjectAssignmentController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{teacher_subject_assignment}', [TeacherSubjectAssignmentController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{teacher_subject_assignment}', [TeacherSubjectAssignmentController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    // =========================================================================
    // Schedules & Statistics
    // =========================================================================

    Route::prefix('class-schedules')->name('class_schedules.')->group(function () {
        Route::get('/grid', [ClassScheduleController::class, 'grid'])->name('grid')->defaults('label','can_view');
        Route::get('/', [ClassScheduleController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [ClassScheduleController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [ClassScheduleController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{class_schedule}', [ClassScheduleController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{class_schedule}/edit', [ClassScheduleController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{class_schedule}', [ClassScheduleController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{class_schedule}', [ClassScheduleController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('id-cards')->name('id_cards.')->group(function () {
        Route::get('/statistics', [IdCardController::class, 'statistics'])->name('statistics')->defaults('label','can_view');
        Route::get('/', [IdCardController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [IdCardController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [IdCardController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{id_card}', [IdCardController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{id_card}/edit', [IdCardController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{id_card}', [IdCardController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{id_card}', [IdCardController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('schedule-patterns')->name('schedule_patterns.')->group(function () {
        Route::get('/', [SchedulePatternController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [SchedulePatternController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [SchedulePatternController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{schedule_pattern}', [SchedulePatternController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{schedule_pattern}/edit', [SchedulePatternController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{schedule_pattern}', [SchedulePatternController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{schedule_pattern}', [SchedulePatternController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('school-day-schedules')->name('school_day_schedules.')->group(function () {
        Route::get('/', [SchoolDayScheduleController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/{schedule}', [SchoolDayScheduleController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{schedule}/edit', [SchoolDayScheduleController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{schedule}', [SchoolDayScheduleController::class, 'update'])->name('update')->defaults('label','can_edit');
    });

    // =========================================================================
    // Calendars & Applications
    // =========================================================================

    Route::prefix('calendars')->name('calendars.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/grid', [CalendarController::class, 'grid'])->name('grid')->defaults('label','can_view');
        Route::get('/events', [CalendarController::class, 'events'])->name('events')->defaults('label','can_view');
        Route::post('/', [CalendarController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{calendar}/show', [CalendarController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::put('/{calendar}', [CalendarController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{calendar}', [CalendarController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [ApplicationController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [ApplicationController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{application}', [ApplicationController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{application}/edit', [ApplicationController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{application}', [ApplicationController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{application}', [ApplicationController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [RoleController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [UserController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [UserController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });

    // =========================================================================
    // Admin & Menu Management
    // =========================================================================

    Route::prefix('menus')->name('menus.')->group(function () {
        // API & Structure Endpoints
        Route::get('/tree', [MenuController::class, 'getMenuTree'])->name('tree')->defaults('label','can_view');
        Route::get('/structure', [MenuController::class, 'getMenuStructure'])->name('structure')->defaults('label','can_view');
        Route::post('/reorder', [MenuController::class, 'reorder'])->name('reorder')->defaults('label','can_edit');
        Route::post('/update-permissions', [MenuController::class, 'updatePermissions'])->name('update_permissions')->defaults('label','can_edit');

        // Standard Resource Routes
        Route::get('/', [MenuController::class, 'index'])->name('index')->defaults('label','can_view');
        Route::get('/create', [MenuController::class, 'create'])->name('create')->defaults('label','can_create');
        Route::post('/', [MenuController::class, 'store'])->name('store')->defaults('label','can_create');
        Route::get('/{menu}', [MenuController::class, 'show'])->name('show')->defaults('label','can_view');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit')->defaults('label','can_edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update')->defaults('label','can_edit');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy')->defaults('label','can_delete');
    });
});
