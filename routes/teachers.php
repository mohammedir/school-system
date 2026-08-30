<?php

use App\Http\Controllers\Teachers\MyProjectsController;
use App\Http\Controllers\Teachers\TeacherController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Teachers\Auth\LoginController;
use App\Http\Controllers\Teachers\Auth\RegisterController;
use App\Http\Controllers\Teachers\LookupsController;
use App\Http\Controllers\Teachers\ProjectsController;

Route::post('lookups/get_children_by_parent', [LookupsController::class, 'get_children_by_parent'])->name('get_children_by_parent');

Route::prefix('teachers')->name('teachers.')->group(function () {
    Route::middleware('guest:teachers')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });
    Route::middleware(['auth:teachers','verified.teachers'])->group(function () {
        Route::get('dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [TeacherController::class, 'profile'])->name('profile');
        Route::get('profile/edit', [TeacherController::class, 'profileEdit'])->name('profile.edit');
        Route::get('profile/show', [TeacherController::class, 'profile'])->name('profile.show');
        Route::put('profile/update', [TeacherController::class, 'profileUpdate'])->name('profile.update');

        Route::get('settings', [TeacherController::class, 'settings'])->name('settings');

        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
        Route::get('/projects/get_projects', [ProjectsController::class, 'get_projects'])->name('get_projects');
        Route::get('/projects/show/{id}', [ProjectsController::class, 'show'])->name('projects.show');
        Route::get('/land/land-details', [ProjectsController::class, 'getLandDetails'])->name('land.getLandDetails');
        Route::get('/investor-details', [ProjectsController::class, 'getInvestorDetails'])->name('getInvestorDetails');
        Route::get('/investor-details', [ProjectsController::class, 'getInvestorDetails'])->name('getInvestorDetails');
        Route::post('/submit_quote/{project_id}', [ProjectsController::class, 'submit_quote'])->name('projects.submit_quote');


        Route::get('/my_projects', [MyProjectsController::class, 'index'])->name('my_projects.index');
        Route::get('/my_projects/get_offers', [MyProjectsController::class, 'get_awardingApproved_offers'])->name('my_projects.get_awardingApproved_offers');
        Route::get('/my_projects/enter_units/{id}', [MyProjectsController::class, 'enter_units'])->name('my_projects.enter_units');
        Route::get('/my_projects/getProjectsDetails', [MyProjectsController::class, 'getProjectsDetails'])->name('my_projects.getProjectsDetails');

        Route::post('/my_projects/save_project_units', [MyProjectsController::class, 'saveProjectUnits'])->name('my_projects.saveProjectUnits');

        Route::get('/notifications/unread', function () {
            return response()->json([
                'count' => auth()->user()->unreadNotifications()->count(),
            ]);
        })->name('notifications.unread');

    });
});



