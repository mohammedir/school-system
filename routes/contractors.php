<?php

use App\Http\Controllers\ContractorsPortal\MyProjectsController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContractorsPortal\Auth\LoginController;
use App\Http\Controllers\ContractorsPortal\Auth\RegisterController;
use App\Http\Controllers\Teachers\LookupsController;
use App\Http\Controllers\ContractorsPortal\ContractorsController;
use App\Http\Controllers\ContractorsPortal\ProjectsController;
use App\Http\Controllers\ContractorsPortal\ContractorsOfferController;

Route::post('lookups/get_children_by_parent', [LookupsController::class, 'get_children_by_parent'])->name('get_children_by_parent');

Route::prefix('contractors')->name('contractors.')->group(function () {
    Route::middleware('guest:contractors')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    });
    // مسجل لكن مش شرط مفعل
    Route::middleware('auth:contractors')->group(function () {
        Route::get('/otp/verify', [RegisterController::class, 'showOtpForm'])->name('otp.form');
        Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
        Route::post('/otp/resend', [RegisterController::class, 'resendOtp'])->name('otp.resend');
        Route::post('/profile/enableAuthapp', [ContractorsController::class, 'enableAuthapp'])->name('2fa.enableAuthapp');
        Route::get('/profile/disableAuthapp', [ContractorsController::class, 'disableAuthapp'])->name('2fa.disableAuthapp');
    });
    Route::middleware(['auth:contractors','verified.contractors'])->group(function () {
        Route::get('dashboardController', function () {
            return view('contractors.dashboard');
        })->name('dashboardController');
        Route::get('profile', [ContractorsController::class, 'profile'])->name('profile');
        Route::get('profile/settings', [ContractorsController::class, 'profile_settings'])->name('profile.settings');
        Route::post('profile/update', [ContractorsController::class, 'update_profile_settings'])->name('profile.update');
        Route::post('profile/update-password', [ContractorsController::class, 'update_password'])->name('profile.update-password');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');


        Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
        Route::get('/projects/get_projects', [ProjectsController::class, 'get_projects'])->name('get_projects');
        Route::get('/projects/show/{id}', [ProjectsController::class, 'show'])->name('projects.show');
        Route::get('/land/land-details', [ProjectsController::class, 'getLandDetails'])->name('land.getLandDetails');
        Route::get('/investor-details', [ProjectsController::class, 'getInvestorDetails'])->name('getInvestorDetails');
        Route::get('/investor-details', [ProjectsController::class, 'getInvestorDetails'])->name('getInvestorDetails');
        Route::post('/submit_quote/{project_id}', [ProjectsController::class, 'submit_quote'])->name('projects.submit_quote');


        Route::get('/contractors_offers', [ContractorsOfferController::class, 'index'])->name('contractors_offers.index');
        Route::get('/contractors_offers/get_offers', [ContractorsOfferController::class, 'get_offers'])->name('contractors_offers.get_offers');
        Route::get('/contractors_offers/show/{id}', [ContractorsOfferController::class, 'show'])->name('contractors_offers.show');
        Route::delete('/contractors_offers/delete/{id}', [ContractorsOfferController::class, 'delete'])->name('contractors_offers.delete');

        Route::get('/my_projects', [MyProjectsController::class, 'index'])->name('my_projects.index');
        Route::get('/my_projects/get_offers', [MyProjectsController::class, 'get_awardingApproved_offers'])->name('my_projects.get_awardingApproved_offers');
        Route::get('/my_projects/enter_units/{id}', [MyProjectsController::class, 'enter_units'])->name('my_projects.enter_units');
        Route::get('/my_projects/getProjectsDetails', [MyProjectsController::class, 'getProjectsDetails'])->name('my_projects.getProjectsDetails');

        Route::post('/my_projects/save_project_units', [MyProjectsController::class, 'saveProjectUnits'])->name('my_projects.saveProjectUnits');


    });
});




