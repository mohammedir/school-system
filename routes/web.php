<?php

use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\InvestorsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ContractorsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SitesController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationStudentsController;
use App\Http\Controllers\UsersController;
use App\Models\Contractors;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Platform\MainController;

 /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Broadcast::routes(['middleware' => ['auth']]);

Route::get('/deploy', function () {
    if (request('key') !== env('DEPLOY_KEY')) {
        abort(403);
    }
    /*
    Artisan::call('migrate', ['--force' => true]);
    return '✅ Done: migrate';
    */

    Artisan::call('migrate:refresh', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);

    return '✅ Done: migrate + seed.';
});
/*Route::get('/', function () {
    return view.blade.php('site.index');
});*/

/*site*/

Route::get('/', [MainController::class, 'index'])->name('site.index');
Route::post('/complaints', [MainController::class, 'complaints'])->name('complaints.store');

Route::get('/sites-get-classes-by-age-group', [MainController::class, 'getClassesByAgeGroup'])
    ->name('sites.get_classes_by_age_group');

// ✅ Route لتسجيل الطلاب
Route::post('/register-student', [RegistrationStudentsController::class, 'storeStudent'])->name('register.student.store');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...

    Route::get('/dashboardController', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboardController');

    Route::middleware( 'auth')->group(function () {
        Route::get('/MyProfile', [ProfileController::class, 'view'])->name('profile.view.blade.php');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


        Route::get('/users/list', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/getUsers', [UsersController::class, 'getUsers'])->name('users.getUsers');
        Route::post('/users/addUsers', [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/view.blade.php/{id}', [UsersController::class, 'view'])->name('users.view.blade.php');
        Route::post('/users/update/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/changePassword/{id}', [UsersController::class, 'changePassword'])->name('users.change-password');
        Route::post('/users/enableAuthapp/{id}', [UsersController::class, 'enableAuthapp'])->name('users.enableAuthapp');
        Route::get('/users/disableAuthapp/{id}', [UsersController::class, 'disableAuthapp'])->name('users.disableAuthapp');


        Route::get('/roles', [RoleController::class,'index'])->name('roles.index');
        Route::get('/view.blade.php-roles/{id}', [RoleController::class,'show'])->name('roles.show');
        Route::post('/store-roles', [RoleController::class,'store'])->name('roles.store');
        Route::get('/edit-roles/{id}', [RoleController::class,'edit'])->name('roles.edit');
        Route::post('/update-roles/{id}', [RoleController::class,'update'])->name('roles.update');




        Route::get('/admin/investor-details', [App\Http\Controllers\Admin\InvestorsController::class, 'getInvestorDetails'])->name('admin.getInvestorDetails');


        Route::get('/student/list', [StudentController::class, 'index'])->name('student.index');
        Route::get('/student/registered_by_website', [StudentController::class, 'registered_by_website'])->name('students.registered_by_website');
        Route::get('/students/getStudents', [StudentController::class, 'getStudents'])->name('students.getStudents');
        Route::get('/students/add-student', [StudentController::class, 'add'])->name('students.add');
        Route::post('/students/store-student', [StudentController::class,'store'])->name('students.store');
        Route::post('/students/update-student/{id}', [StudentController::class,'update'])->name('students.update');
        Route::get('/students/view.blade.php-student/{id}', [StudentController::class,'view'])->name('students.view.blade.php');
        Route::get('/students/get-classes-by-age-group', [StudentController::class, 'getClassesByAgeGroup'])->name('students.get.classes.by.age.group');
        Route::get('/students/search-by-id/{student_id}', [StudentController::class, 'searchStudentData'])->name('students.search.by.id');
        Route::get('/students/edit-student/{id}', [StudentController::class,'edit'])->name('students.edit');
        Route::get('/get-classes-by-age-group', [StudentController::class, 'getClassesByAgeGroup'])
            ->name('get.classes.by.age.group');
        // ✅ تصدير البيانات
        Route::get('students/export', [StudentController::class, 'exportStudents'])->name('students.export');


        /*إدارة الموقع*/
            // عرض جدول الشكاوى
            Route::get('admin/sits/complaints',[SitesController::class,'complaints'])->name('sits.complaints');
            Route::get('admin/sits/registrations_students',[SitesController::class,'registrations_students'])->name('sits.registrations_students');


            // جلب بيانات  للـ DataTable (AJAX)
            Route::get('admin/sits/complaints/data', [SitesController::class, 'getComplaintsData'])->name('admin.complaints.getData');
            Route::get('admin/sits/registrationsStudents/data', [SitesController::class, 'getRegistrationsStudentsData'])->name('admin.registrations_students.getData');

            // عرض تفاصيل
            Route::get('admin/sits/complaints/{id}/details', [SitesController::class, 'getComplaintDetails'])->name('admin.complaints.details');
            Route::get('admin/sits/registrationsStudents/{id}/details', [SitesController::class, 'getRegistrationsStudentsDetails'])->name('admin.registrations_students.details');

            Route::get('admin/sits/registrationsStudents/{id}/edite', [SitesController::class, 'getRegistrationsStudentsEdite'])->name('admin.registrations_students.edite');

            // تحديث حالة الشكوى
            Route::put('admin/sits/complaints/{id}/status', [SitesController::class, 'updateComplaintStatus'])->name('admin.complaints.update-status');

            // حذف الشكوى
            Route::delete('admin/sits/complaints/{id}', [SitesController::class, 'deleteComplaint'])->name('admin.complaints.delete');

            Route::prefix('admin/teachers')->name('admin.teachers.')->group(function () {
                Route::get('/list',[TeacherController::class,'list'])->name('list');
                Route::get('/getTeachers',[TeacherController::class,'getTeachers'])->name('getTeachers');
                Route::get('/view-teacher/{id}',[TeacherController::class,'viewTeacher'])->name('viewTeacher');
                Route::post('/activate/{id}', [TeacherController::class, 'activateTeacher'])->name('activate');
                Route::post('/change-status/{id}', [TeacherController::class, 'changeStatus'])->name('change-status');
            });


        Route::get('/settings',[SettingController::class,'index'])->name('settings.general');
        Route::post('/settings',[SettingController::class,'index'])->name('settings.general');
        Route::get('/settings/manage-lists',[SettingController::class,'manage_lists'])->name('settings.manage_lists');
        Route::get('/settings/get-manage-lists-data',[SettingController::class,'get_manage_lists_data'])->name('settings.get_manage_lists_data');
        Route::get('/settings/settings-list/{id}',[SettingController::class,'settings_list'])->name('settings.settings_list');
        Route::post('/settings/add-item',[SettingController::class,'add_item'])->name('settings.add_item');
        Route::post('/settings/edit-item/{id}',[SettingController::class,'edit_item'])->name('settings.edit_item');
        Route::delete('/settings/delete-item/{id}',[SettingController::class,'delete_item'])->name('settings.delete_item');

        Route::get('/admin/investors',[InvestorsController::class,'index'])->name('investors.list');
        Route::post('/admin/investors/accredit/{id}', [InvestorsController::class, 'accredit'])->name('investors.accredit');
        Route::post('/admin/investors/reject/{id}', [InvestorsController::class, 'reject'])->name('investors.reject');
        Route::get('/admin/add-investor',[InvestorsController::class,'add'])->name('investors.add');
        Route::post('/admin/store-investor',[InvestorsController::class,'store'])->name('investors.store');
        Route::get('/admin/edit-investor/{id}',[InvestorsController::class,'edit'])->name('investors.edit');
        Route::get('/admin/approval-investor/{id}',[InvestorsController::class,'approval'])->name('investors.approval');
        Route::post('/admin/update-investor/{id}',[InvestorsController::class,'update'])->name('investors.update');
        Route::get('/admin/view.blade.php-investor/{id}',[InvestorsController::class,'view.blade.php'])->name('investors.view.blade.php');
        Route::get('/admin/view.blade.php-waiting-approval-list',[InvestorsController::class,'view_waiting_approval_list'])->name('investors.view_waiting_approval_list');


        Route::get('/admin/getInvestors',[InvestorsController::class,'getInvestors'])->name('investors.getInvestors');
        Route::get('/admin/getWaitingApprovalInvestors',[InvestorsController::class,'getWaitingApprovalInvestors'])->name('investors.getWaitingApprovalInvestors');


        Route::get('/notifications/unread', function () {
            return response()->json([
                'count' => auth()->user()->unreadNotifications()->count(),
            ]);
        })->name('notifications.unread');

        Route::get('/notifications/list', [NotificationController::class,'list'])->name('notifications.list');
        Route::get('/engineering-notifications/list', [NotificationController::class,'engineering_notifications_list'])->name('engineering_notifications.list');
        Route::get('/settings/notifications', [NotificationController::class,'pageList'])->name('notifications.pageList');
        Route::get('/settings/notifications/getpageListData', [NotificationController::class,'getpageListData'])->name('notifications.getpageListData');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);

    });

    require __DIR__.'/auth.php';


});



