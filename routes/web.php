<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BackSubjectController;
use App\Http\Controllers\ChairmanController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormSection;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StrandController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function(){
    return view('welcomeOrig');
});

// Auth route
Route::middleware(['guest:web', 'guest:teacher', 'guest:student', 'preventBackHistory'])->name('auth.')->group(function () {
    // Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('login/post', [AuthController::class, 'login_post'])->name('login_post');
});

//logout
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    //pre enrollment
    Route::get('welcome', [FormController::class, 'welcome'])->name('welcome');
    Route::get('done/{tracking}', [FormController::class, 'done'])->name('done');
    Route::get('form', [FormController::class, 'form'])->name('form');
    Route::post('form/save', [FormController::class, 'store']);
    Route::get('form/check/lrn/{lrn}', [FormController::class, 'checkLRN']);
Route::get('done/download/form/{tracking_no}', [ExportController::class, 'exportEnrollmentForm'])->name('done.download');


// Route::get('welcome', [FormSection::class, 'welcome'])->name('welcome');
// Route::get('done/{tracking}', [FormSection::class, 'done'])->name('done');
// Route::get('form', [FormSection::class, 'form'])->name('form');
// Route::post('form/save', [FormSection::class, 'store']);
// Route::get('form/check/lrn/{lrn}', [FormSection::class, 'checkLRN']);

//appointment
Route::get('appoint/register', [AppointmentController::class, 'appoint'])->name('appoint');
    Route::get('appoint/holiday/list', [AppointmentController::class, 'showHolidayList']);
    Route::post('appoint/save', [AppointmentController::class, 'appointSave'])->name('appoint.save');
    Route::get('appoint/success/{appointment}', [AppointmentController::class, 'showSucccess']);
Route::get('appoint/list', [AppointmentController::class, 'showAppointList']);


Route::middleware(['auth:web', 'preventBackHistory'])->name('admin.')->prefix('admin/my/')->group(function () {

    // dashboard route
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


    //reset password
    Route::get('reset/password/{id}/{type}', [AdminController::class, 'resetPassword']);

   // announcement route
   Route::get('announcement', [AdminController::class, 'announcement'])->name('announcement');
   Route::post('announcement/create', [AnnouncementController::class, 'create']);
   Route::get('announcement/list', [AnnouncementController::class, 'list']);
   Route::get('announcement/edit/{announcement}', [AnnouncementController::class, 'edit']);
   Route::delete('announcement/delete/{announcement}', [AnnouncementController::class, 'destroy']);

    // chart
    Route::get('chart/population/by/level', [ChartController::class, 'populationByGradeLevel']);
    Route::get('chart/population/by/sex', [ChartController::class, 'populationBySex']);
    Route::get('chart/population/by/curriculum', [ChartController::class, 'populationByCurriculum']);


    // admission route
    Route::get('admission', [AdminController::class, 'admission'])->name('admission');

    // enrollment route
    Route::get('enrollment', [AdminController::class, 'enrollment'])->name('enrollment');
    Route::get('enrollment/list/{level}/{year}', [EnrollmentController::class, 'masterList']);
    Route::post('enrollment/status', [EnrollmentController::class, 'changeStatus']);
    Route::get('enrollment/export/by/level/{schoolyear}/{level}', [ExportController::class, 'exportMasterList']);

    // appointment route
    Route::get('appointment', [AdminController::class, 'appointment'])->name('appointment');
    Route::post('holiday/save', [AppointmentController::class, 'holidaySave']);
    Route::get('holiday/list', [AppointmentController::class, 'holidayList']);
    Route::get('holiday/edit/{holiday}', [AppointmentController::class, 'holidayEdit']);
    Route::delete('holiday/delete/{holiday}', [AppointmentController::class, 'holidayDelete']);
    Route::get('appointment/list/{month}', [AppointmentController::class, 'getAvailAppoint']);
    Route::get('appointment/list/selected/{selectedDate}', [AppointmentController::class, 'selectedDate']);
    Route::get('appointment/print/report/{dateSelected}', [AppointmentController::class, 'printReport']);
    Route::post('appointment/send/email', [AppointmentController::class, 'sendEmailNotify']);
    Route::get('appointment/export/number/{date}', [ExportController::class, 'exportNumber']);

    // teacher-route
    Route::get('teacher', [AdminController::class, 'teacher'])->name('teacher');
    Route::get('teacher/list', [TeacherController::class, 'list']);
    Route::post('teacher/store', [TeacherController::class, 'store']);
    Route::post('teacher/import', [ImportController::class, 'importTeacher']);
    Route::get('teacher/import/template', [ImportController::class, 'importTeacherTemplate'])->name('download.template.teacher');
    Route::get('teacher/edit/{teacher}', [TeacherController::class, 'edit']);
    Route::delete('teacher/delete/{id}', [TeacherController::class, 'delete']);

    // student-route
    Route::get('student', [AdminController::class, 'student'])->name('student');
    Route::post('student/save', [StudentController::class, 'store']);
    Route::post('student/import', [ImportController::class, 'importStudent']);
    Route::get('student/list', [StudentController::class, 'list']);
    Route::get('student/import/template', [ImportController::class, 'importStudentTemplate'])->name('download.template.student');
    Route::delete('student/delete/{student}', [StudentController::class, 'destroy']);
    Route::get('student/edit/{student}', [StudentController::class, 'edit']);
    Route::get('student/view/record/{student}', [StudentController::class, 'viewRecord']);

    // archive
    Route::get('archive', [AdminController::class, 'archive'])->name('archive');
    Route::get('archive/list/{type}', [AdminController::class, 'archiveList']);
    Route::delete('archive/force/delete/{type}/{id}', [AdminController::class, 'archieveForceDelete']);
    Route::post('archive/restore/{type}/{id}', [AdminController::class, 'archiveRestore']);

    // backrecord
    Route::get('backrecord', [AdminController::class, 'backrecord'])->name('backrecord');
    Route::get('backrecord/list', [BackSubjectController::class, 'backrecordList']);
    Route::get('backrecord/view/{id}', [BackSubjectController::class, 'backrecordView']);
    Route::patch('backrecord/update/{id}', [BackSubjectController::class, 'updateNow']);

    // profile-route
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('profile/save', [AdminController::class, 'storeProfile']);

    //strand and track
    Route::get('strand', [AdminController::class, 'strandAndTrack'])->name('strand');
    Route::post('strand/save', [StrandController::class, 'storeStrand']);
    Route::get('strand/list', [StrandController::class, 'listStrand']);
    Route::get('strand/edit/{strand}', [StrandController::class, 'editStrand']);
    Route::delete('strand/delete/{strand}', [StrandController::class, 'destroyStrand']);

    // section-route
    Route::get('section', [AdminController::class, 'section'])->name('section');
    Route::get('section/list/{grade_level}', [SectionController::class, 'list']);
    Route::post('section/save', [SectionController::class, 'store']);
    Route::get('section/edit/{section}', [SectionController::class, 'edit']);
    Route::delete('section/delete/{id}', [SectionController::class, 'destroy']);
    Route::post('section/check-section', [SectionController::class, 'checkSection']);

    // subject-route
    Route::get('subject', [AdminController::class, 'subject'])->name('subject');
    Route::get('subject/list/{grade_level}', [SubjectController::class, 'list']);
    Route::post('subject/save', [SubjectController::class, 'store']);
    Route::get('subject/edit/{subject}', [SubjectController::class, 'edit']);
    Route::delete('subject/delete/{subject}', [SubjectController::class, 'destroy']);
    Route::get('subject/check/{subject_code}/{grade_level}', [SubjectController::class, 'checkSubject']);

    // schedule
    Route::get('schedule', [AdminController::class, 'schedule'])->name('schedule');
    Route::get('search/type/{type}', [ScheduleController::class, 'searchType']);
    Route::get('search/section/{grade_level}', [ScheduleController::class, 'searchBySection']);
    Route::get('search/subject/{section}', [ScheduleController::class, 'searchBySubject']);
    Route::post('schedule/save', [ScheduleController::class, 'store']);
    Route::get('schedule/list/{type}/{value}', [ScheduleController::class, 'list']);
    Route::delete('schedule/delete/{schedule}', [ScheduleController::class, 'destroy']);
    Route::get('schedule/edit/{schedule}', [ScheduleController::class, 'edit']);

    // Assign
    Route::get('assign', [AdminController::class, 'assign'])->name('assign');
    Route::get('search/{grade_level}', [AssignController::class, 'search']);
    Route::get('assign/search/section/{grade_level}', [AssignController::class, 'searchBySection']);
    Route::get('assign/search/subject/{section}/{action}', [AssignController::class, 'searchBySubject']);
    Route::post('assign/save', [AssignController::class, 'store']);
    Route::get('assign/list/{section}', [AssignController::class, 'list']);
    Route::delete('assign/delete/{assign}', [AssignController::class, 'destroy']);
    Route::get('assign/edit/{assign}', [AssignController::class, 'edit']);

    //Grading
    Route::get('grading', [AdminController::class, 'grading'])->name('grading');
    Route::get('grading/search/section/{grade_level}', [GradeController::class, 'searchBySection']);
    Route::get('grading/search/subject/{section}', [GradeController::class, 'searchBySubject']);
    Route::get('grading/load/all/student/{section}/{subject}', [GradeController::class, 'loadMyStudent']);
    Route::post('grading/student/now', [GradeController::class, 'gradeStudentNow']);

    // chairman route
    Route::get('chairman', [AdminController::class, 'chairman'])->name('chairman');
    Route::get('chairman/list', [ChairmanController::class, 'list']);
    Route::post('chairman/save', [ChairmanController::class, 'store']);
    Route::delete('chairman/delete/{chairman}', [ChairmanController::class, 'destroy']);
    Route::get('chairman/edit/{chairman}', [ChairmanController::class, 'edit']);

    // academic-year route
    Route::get('academic-year', [AdminController::class, 'academicYear'])->name('academicYear');
    Route::post('academic-year/save', [AdminController::class, 'storeAY']);
    Route::get('academic-year/list', [AdminController::class, 'listAY']);
    Route::post('academic-year/change/{id}', [AdminController::class, 'changeAY']);
    Route::delete('academic-year/delete/{id}', [AdminController::class, 'deleteAY']);
    Route::get('academic-year/edit/{schoolYear}', [AdminController::class, 'editAY']);

    //admin users
    Route::get('user', [AdminController::class, 'user'])->name('user');
    Route::post('user/save', [UserController::class, 'store']);
    Route::get('user/list', [UserController::class, 'list']);
    Route::delete('user/delete/{user}', [UserController::class, 'destroy']);
    Route::get('user/edit/{user}', [UserController::class, 'edit']);

    //activity log
    Route::get('activity', [AdminController::class, 'activityLog'])->name('log');
    Route::get('activity/log/{from}/{to}', [AdminController::class, 'searchByDate']);

    Route::get('backup/run', function () {
        Artisan::call('backup:run');
        return redirect()->back();
    })->name('backup.run');
    Route::get('backup/donwload/{file_name}', [AdminController::class, 'backUpDonwload']);
    Route::post('backup/remove/{file_name}', [AdminController::class, 'backUpRemove']);

    Route::put('grade/update/status', [AdminController::class, 'gradeStatus']);
    
});

Route::middleware(['auth:teacher', 'preventBackHistory'])->name('teacher.')->prefix('teacher/my/')->group(function () {
    Route::get('dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');

    Route::get('profile', [TeacherController::class, 'profile'])->name('profile');
    Route::post('profile/update', [TeacherController::class, 'profileUpdate'])->name('profile.update');
    Route::post('profile/account', [TeacherController::class, 'profileAccount'])->name('profile.account');
    
    // chairman-manage-section-route
    Route::get('section', [ChairmanController::class, 'section'])->name('section');
    Route::get('section/list', [ChairmanController::class, 'sectionList']);
    Route::post('section/save', [ChairmanController::class, 'sectionSave']);
    Route::get('section/edit/{section}', [ChairmanController::class, 'sectionEdit']);
    Route::delete('section/delete/{section}', [ChairmanController::class, 'sectionDestroy']);
    Route::post('section/check-section', [ChairmanController::class, 'checkSection']);

    //enrollment form
    Route::get('enrollmentForm', [ChairmanController::class, 'enrollmentForm'])->name('enrollmentForm');

    // chairman-manage-enroll-route

    // STEM route
    Route::get('stem', [ChairmanController::class, 'stempage'])->name('stem');

    //BEC route
    Route::get('bec', [ChairmanController::class, 'becpage'])->name('bec');

    //SPA route
    Route::get('spa', [ChairmanController::class, 'spapage'])->name('spa');

    //SPJ route
    Route::get('spj', [ChairmanController::class, 'spjpage'])->name('spj');

    // crud and monitor per level chairman
    Route::get('table/list/{class}', [ChairmanController::class, 'tableList']);
    Route::get('table/list/filtered/{class}/{barangay}', [ChairmanController::class, 'tableListFiltred']);
    Route::get('table/list/enrolled/student/{section}', [ChairmanController::class, 'tableListEnrolledStudent']);
    Route::get('section/search/by/level/{curriculum}', [ChairmanController::class, 'searchSecionByLevel']);
    Route::post('section/set', [EnrollmentController::class, 'setSection']);
    Route::post('section/mass/sectioning', [EnrollmentController::class, 'massSectioning']);
    Route::get('edit/{enrollment}', [EnrollmentController::class, 'edit']);
    Route::get('filter/section/{curriculum}', [EnrollmentController::class, 'filterSection']);
    Route::delete('delete/{enrollment}', [EnrollmentController::class, 'destroy']);
    Route::get('monitor/section/{curriculum}', [ChairmanController::class, 'monitorSection']);
    Route::get('filter/barangay/{curriculum}', [ChairmanController::class, 'filterbarangay']);
    Route::get('dash/monitor', [ChairmanController::class, 'dashMonitor']);
    Route::get('print/report/{section}', [ChairmanController::class, 'printReport']);
    // Route::get('autofill/{roll_no}', [ChairmanController::class, 'autofill']);

    //enrollment form manually aading student
    Route::get('check/lrn/{lrn}/{curriculum}/{status}', [EnrollmentController::class, 'checkLRN']);
    Route::post('save', [EnrollmentController::class, 'store']);

    // for advicer route
    Route::get('class/monitor', [TeacherController::class, 'classMonitor'])->name('class.monitor');
    Route::get('class/monitor/list', [EnrollmentController::class, 'myClass']);
    Route::post('class/monitor/dropped/{enrollment}', [EnrollmentController::class, 'dropped']);
    Route::get('class/report/card/{id}', [TeacherController::class, 'reportCard']);
    Route::get('grading', [TeacherController::class, 'grading'])->name('grading');

    //assign subject
    Route::get('assign', [TeacherController::class, 'assign'])->name('class.assign');
    Route::post('assign/save', [TeacherController::class, 'assignStore']);
    Route::delete('assign/delete/{assign}', [TeacherController::class, 'assignDelete']);
    Route::get('assign/edit/{assign}', [TeacherController::class, 'assignEdit']);
    Route::get('assign/list/{section}', [TeacherController::class, 'assignList']);


    // subject Teacher
    Route::get('grading', [TeacherController::class, 'grading'])->name('grading');
    Route::get('grading/load/subject', [TeacherController::class, 'loadMySection']);
    Route::get('grading/load/student/{section}/{subject}', [TeacherController::class, 'loadMyStudent']);
    Route::post('grade/student/now', [GradeController::class, 'gradeStudentNow']);

    //export subject teacher template class
    Route::get('export/grade/{section}/{subject}', [ExportController::class, 'exportMyTemplate']);
    //import subject teacher template class
    Route::post('import/grade/{section}/{subject}', [ImportController::class, 'importMyTemplate']);
    
     // Certificate
     Route::get('certificate', [TeacherController::class, 'certificate'])->name('certificate');
     Route::get('certificate/load/student', [TeacherController::class, 'loadMyEnrolledStudent']);
     Route::get('certificate/load/certificate/{student}', [TeacherController::class, 'loadMyCertificate']);
     
    // export file
    Route::get('export/excel/{format}/{status}/{curriculum}/{grade_level}', [ExportController::class, 'exportNewEnrollee']);
});

Route::middleware(['auth:student', 'preventBackHistory'])->name('student.')->prefix('student/my/')->group(function () {
    Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('student/save', [StudentController::class, 'store']);
    Route::post('student/profile/save', [StudentController::class, 'storeProfileImage']);
    Route::get('grade', [StudentController::class, 'grade'])->name('grade');
    Route::get('grade/list/{level}/{section}', [StudentController::class, 'gradeList']);
    Route::get('level/list', [StudentController::class, 'levelList']);
    Route::get('enrollment', [StudentController::class, 'enrollment'])->name('enrollment');
    Route::get('backsubject', [StudentController::class, 'backsubject'])->name('backsubject');
    Route::get('backsubject/list', [BackSubjectController::class, 'backsubjectList']);
    Route::get('check/subject/balance/{student}', [StudentController::class, 'checkSubjectBalance']);
    Route::post('self/enroll', [StudentController::class, 'selfEnroll']);
    Route::get('report', [StudentController::class, 'reportBug'])->name('report');
    Route::get('appointment', [StudentController::class, 'appointment'])->name('appointment');
    Route::get('notification', [StudentController::class, 'notificationStudent'])->name('notificationStudent');
    Route::get('markAsRead',function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('markAsRead');
    Route::get('deleteNotification',function(){
        auth()->user()->notifications()->delete();
        return redirect()->back();
    })->name('deleteNotification');
});

Route::get('/clear', function () { //-> tawagin mo to url sa browser -> 127.0.0.1:8000/clear
    Artisan::call('view:clear'); //   -> Clear all compiled files
    Artisan::call('route:clear'); //  -> Remove the route cache file 
    Artisan::call('optimize:clear'); //-> Remove the cache bootstrap files
    Artisan::call('event:clear'); //   -> clear all cache events and listener
    Artisan::call('config:clear'); //  -> Remove the configuration cache file
    Artisan::call('cache:clear'); //   -> Flush the application cache
    return back();
});

