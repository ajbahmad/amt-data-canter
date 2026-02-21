<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\FeeController;
use App\Http\Controllers\admin\OccupationController;
use App\Http\Controllers\admin\ClassCategoryController;
use App\Http\Controllers\admin\StudyController;
use App\Http\Controllers\admin\BatchController;
use App\Http\Controllers\admin\ClassroomController;
use App\Http\Controllers\admin\MentorController;
use App\Http\Controllers\admin\GradeController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\CourseEnrollmentController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\MentorScheduleController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\MonthlyPaymentController;
use App\Http\Controllers\admin\PlacementTestController;
use App\Http\Controllers\admin\AttendanceController;
use App\Http\Controllers\admin\AchievementTestController;
use App\Http\Controllers\admin\CertificateController;
use App\Http\Controllers\admin\IssuedCertificateController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::group(['middleware' => ['auth', 'role']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Master Data Routes
        Route::resource('fees', FeeController::class);
        Route::resource('occupations', OccupationController::class);
        Route::resource('class-categories', ClassCategoryController::class);
        Route::resource('studies', StudyController::class);
        Route::resource('batches', BatchController::class);

        // Classroom dropdown data routes (must be before resource route)
        
        Route::get('classrooms/study-levels', [ClassroomController::class, 'getStudyLevels'])->name('classrooms.study-levels');
        Route::post('classrooms/{classroom_id}/students', [ClassroomController::class, 'addStudents'])->name('classrooms.add.students.store');
        Route::get('classrooms/class-categories', [ClassroomController::class, 'getClassCategories'])->name('classrooms.class-categories');
        Route::delete('classrooms/{classroom_id}/students/{student_id}', [ClassroomController::class, 'removeStudent'])->name('classrooms.remove.student');
        Route::resource('classrooms', ClassroomController::class);

        // Mentor Routes
        Route::get('mentors/studies', [MentorController::class, 'getStudies'])->name('mentors.studies');
        Route::resource('mentors', MentorController::class);

        // Grade Routes
        Route::resource('grades', GradeController::class);

        // Student Routes
        Route::resource('students', StudentController::class);
        // Student print (PDF) - prints student detail as PDF
        Route::get('students/{student}/print', [StudentController::class, 'print'])->name('students.print');

        // Course Enrollment Routes
        Route::get('course-enrollments/api/studies', [CourseEnrollmentController::class, 'getStudies'])->name('course-enrollments.studies');
        Route::get('course-enrollments/api/fees', [CourseEnrollmentController::class, 'getFees'])->name('course-enrollments.fees');
        Route::get('course-enrollments/{courseEnrollment}/print-register', [CourseEnrollmentController::class, 'printRegister'])->name('course-enrollments.print-register');
        Route::get('course-enrollments/{courseEnrollment}/print-payment', [CourseEnrollmentController::class, 'printPayment'])->name('course-enrollments.print-payment');
        Route::get('course-enrollments/print-invoice-payment', [CourseEnrollmentController::class, 'printInvoicePayment'])->name('course-enrollments.print-invoice-payment');
        Route::post('course-enrollments/{courseEnrollment}/confirm', [CourseEnrollmentController::class, 'confirm'])->name('course-enrollments.confirm');
        Route::post('course-enrollments/{courseEnrollment}/confirm-payment', [CourseEnrollmentController::class, 'confirmPayment'])->name('course-enrollments.confirm-payment');
        Route::post('course-enrollments/{courseEnrollment}/cancel', [CourseEnrollmentController::class, 'cancel'])->name('course-enrollments.cancel');
        Route::resource('course-enrollments', CourseEnrollmentController::class);

        // Invoice Routes
        Route::post('invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
        Route::post('invoices/{invoice}/mark-as-unpaid', [InvoiceController::class, 'markAsUnpaid'])->name('invoices.mark-as-unpaid');
        Route::get('invoices/{invoice}/download-attachment', [InvoiceController::class, 'downloadAttachment'])->name('invoices.download-attachment');
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoices.pdf');
        Route::resource('invoices', InvoiceController::class);

        // Schedule Routes
        Route::get('schedules/weekly', [ScheduleController::class, 'weekly'])->name('schedules.weekly');
        Route::get('schedules/daily', [ScheduleController::class, 'daily'])->name('schedules.daily');
        Route::post('schedules/{schedule}/duplicate', [ScheduleController::class, 'duplicate'])->name('schedules.duplicate');
        Route::resource('schedules', ScheduleController::class);

        // Mentor Schedule Routes
        Route::get('mentor-schedules/weekly', [MentorScheduleController::class, 'weekly'])->name('mentor-schedules.weekly');
        Route::get('mentor-schedules/daily', [MentorScheduleController::class, 'daily'])->name('mentor-schedules.daily');
        Route::get('mentor-schedules/workload', [MentorScheduleController::class, 'workloadStats'])->name('mentor-schedules.workload');
        Route::get('mentor-schedules/available-schedules', [MentorScheduleController::class, 'getAvailableSchedules'])->name('mentor-schedules.available-schedules');
        Route::post('mentor-schedules/assign-bulk', [MentorScheduleController::class, 'assignBulk'])->name('mentor-schedules.assign-bulk');
        Route::post('mentor-schedules/remove-bulk', [MentorScheduleController::class, 'removeBulk'])->name('mentor-schedules.remove-bulk');
        Route::resource('mentor-schedules', MentorScheduleController::class);

        // Profile Routes
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::delete('profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
        Route::get('profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
        Route::put('profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.update-settings');

        // User Management Routes
        Route::resource('users', UserController::class);
        Route::put('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Monthly Payment Routes
        Route::resource('monthly-payments', MonthlyPaymentController::class);
        Route::patch('monthly-payments/{monthlyPayment}/mark-paid', [MonthlyPaymentController::class, 'markAsPaid'])->name('monthly-payments.mark-paid');
        Route::patch('monthly-payments/{monthlyPayment}/mark-unpaid', [MonthlyPaymentController::class, 'markAsUnpaid'])->name('monthly-payments.mark-unpaid');
        Route::post('monthly-payments/generate', [MonthlyPaymentController::class, 'generateMonthly'])->name('monthly-payments.generate');

        // Placement Test Routes
        
        Route::get('placement-tests/courses-students-by-study/{study}', [PlacementTestController::class, 'getCourseStudentsByStudy'])->name('placement-tests.course-students-by-study');
        Route::get('placement-tests/students-by-study/{study}', [PlacementTestController::class, 'getStudentsByStudy'])->name('placement-tests.students-by-study');
        Route::get('placement-tests/export', [PlacementTestController::class, 'export'])->name('placement-tests.export');
        Route::post('placement-tests/bulk-delete', [PlacementTestController::class, 'bulkDelete'])->name('placement-tests.bulk-delete');
        Route::resource('placement-tests', PlacementTestController::class);

        // Study Levels Routes
        Route::post('studies/{study}/levels', [StudyController::class, 'storeLevel'])->name('studies.levels.store');
        Route::get('studies/{study}/levels', [StudyController::class, 'getLevels'])->name('studies.levels.index');
        Route::get('studies/{study}/levels/{level}/edit', [StudyController::class, 'editLevel'])->name('studies.levels.edit');
        Route::put('studies/{study}/levels/{level}', [StudyController::class, 'updateLevel'])->name('studies.levels.update');
        Route::delete('studies/{study}/levels/{level}', [StudyController::class, 'destroyLevel'])->name('studies.levels.destroy');

        // Attendance Routes
        Route::get('attendances/students-by-schedule/{schedule}', [AttendanceController::class, 'getStudentsBySchedule'])->name('attendances.students-by-schedule');
        Route::get('attendances/report', [AttendanceController::class, 'report'])->name('attendances.report');
        Route::post('attendances/bulk-entry', [AttendanceController::class, 'bulkEntry'])->name('attendances.bulk-entry');
        Route::resource('attendances', AttendanceController::class);

        // Achievement Test Routes
        Route::get('achievement-tests/students-by-class/{classroom}', [AchievementTestController::class, 'getStudentsByClass'])->name('achievement-tests.students-by-class');
        Route::get('achievement-tests/bulk-create', [AchievementTestController::class, 'bulkCreate'])->name('achievement-tests.bulk-create');
        Route::post('achievement-tests/bulk-store', [AchievementTestController::class, 'bulkStore'])->name('achievement-tests.bulk-store');
        Route::get('achievement-tests/report', [AchievementTestController::class, 'report'])->name('achievement-tests.report');
        Route::get('achievement-tests/export', [AchievementTestController::class, 'export'])->name('achievement-tests.export');
        Route::post('achievement-tests/auto-promote', [AchievementTestController::class, 'autoPromote'])->name('achievement-tests.auto-promote');
        Route::resource('achievement-tests', AchievementTestController::class);


        // Certificate Routes
        // Route::get('certificates/studies/{study}/levels', [CertificateController::class, 'getStudyLevels'])->name('certificates.study-levels');
        // Route::post('certificates/issue', [CertificateController::class, 'issue'])->name('certificates.issue');
        // Route::post('certificates/bulk-issue', [CertificateController::class, 'bulkIssue'])->name('certificates.bulk-issue');
        Route::post('certificates/{certificate}/post-preview', [CertificateController::class, 'postPreview'])->name('certificates.post.preview');
        Route::post('certificates/upload-font', [CertificateController::class, 'uploadFont'])->name('certificates.upload.font');
        Route::post('certificates/{certificate}/toggle-active', [CertificateController::class, 'toggleActive'])->name('certificates.toggle.active');
        Route::get('certificates/{certificate}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');
        Route::get('certificates/{member}/download', [CertificateController::class, 'download'])->name('certificates.download');
        Route::get('certificates/issued', [IssuedCertificateController::class, 'index'])->name('certificates.isused.index');
        Route::post('certificates/issued', [IssuedCertificateController::class, 'store'])->name('certificates.isused.store');
        Route::get('certificates/issued/{issuedCertificateId}/students', [IssuedCertificateController::class, 'students'])->name('certificates.isused.students');
        Route::resource('certificates', CertificateController::class);

        // Issued Certificate Routes
        // Route::get('issued-certificates/{issuedCertificate}/download', [IssuedCertificateController::class, 'download'])->name('issued-certificates.download');
        // Route::post('issued-certificates/{issuedCertificate}/regenerate', [IssuedCertificateController::class, 'regenerate'])->name('issued-certificates.regenerate');
        // Route::post('issued-certificates/bulk-download', [IssuedCertificateController::class, 'bulkDownload'])->name('issued-certificates.bulk-download');
        // Route::get('issued-certificates/statistics', [IssuedCertificateController::class, 'statistics'])->name('issued-certificates.statistics');
        // Route::resource('certificates/issued', IssuedCertificateController::class)->names('issued-certificates');
        
    });
});
