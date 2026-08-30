<?php

use App\Http\Controllers\Platform\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Platform\Auth\LoginController;
use App\Http\Controllers\Platform\Auth\RegisterController;



Route::name('investors.')->group(function () {
    Route::middleware('guest:investors')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::get('register_data', [RegisterController::class, 'showRegisterDataForm'])->name('register_data');
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('register_data', [RegisterController::class, 'register_data'])->name('register_data');
        Route::post('register_as_investor', [RegisterController::class, 'register_as_investor'])->name('register_as_investor');
        Route::post('login_as_investor', [LoginController::class, 'login_as_investor'])->name('login_as_investor');
    });
    // مسجل لكن مش شرط مفعل
   /* Route::middleware('auth:investors')->group(function () {
        Route::get('/otp/verify', [RegisterController::class, 'showOtpForm'])->name('otp.form');
        Route::post('/otp/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
        Route::post('/otp/resend', [RegisterController::class, 'resendOtp'])->name('otp.resend');
    });*/
    Route::middleware(['auth:investors'/*,'verified.investors'*/])->group(function () {
        Route::get('/investors/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/investors/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
        Route::post('/investors/profile/update-email', [DashboardController::class, 'updateEmail'])->name('profile.updateEmail');
        Route::post('/investors/profile/update-mobile', [DashboardController::class, 'updateMobile'])->name('profile.updateMobile');
        Route::post('/investors/emailOtp', [DashboardController::class, 'emailOtp'])->name('dashboard.emailOtp');
        Route::post('/investors/verifyEmailOtp', [DashboardController::class, 'verifyEmailOtp'])->name('dashboard.verifyEmailOtp');
        Route::post('/investors/sendVerifyData', [DashboardController::class, 'sendVerifyData'])->name('dashboard.sendVerifyData');
        Route::get('/investors/add_land', [DashboardController::class, 'add_land'])->name('dashboard.add_land');
        Route::post('/investors/add_land', [DashboardController::class, 'add_land'])->name('dashboard.add_land');
        Route::get('/investors/delete_land/{land_id}', [DashboardController::class, 'delete_land'])->name('dashboard.delete_land');
        Route::get('/investors/view_land/{land_id}', [DashboardController::class, 'view_land'])->name('dashboard.view_land');
        Route::get('/investors/edit_land/{land_id}', [DashboardController::class, 'edit_land'])->name('dashboard.edit_land');
        Route::post('/investors/edit_land/{land_id}', [DashboardController::class, 'edit_land'])->name('dashboard.edit_land');
        Route::get('/investors/my_land', [DashboardController::class, 'my_land'])->name('dashboard.my_land');
        Route::get('/investors/all_land', [DashboardController::class, 'all_land'])->name('dashboard.all_land');
        Route::get('/investors/get_all_land', [DashboardController::class, 'get_all_land'])->name('dashboard.get_all_land');
        Route::get('/investors/get_my_land', [DashboardController::class, 'get_my_land'])->name('dashboard.get_my_land');
        Route::post('/investors/updatePrice_lands', [DashboardController::class, 'update_price_lands'])->name('dashboard.update_price_lands');
        Route::get('/investors/add_project/{land_id}', [DashboardController::class, 'add_project'])->name('dashboard.add_project');
        Route::post('/investors/add_project/{land_id}', [DashboardController::class, 'add_project'])->name('dashboard.add_project');
        Route::get('/investors/view_project/{project_id}', [DashboardController::class, 'view_project'])->name('dashboard.view_project');
        Route::get('/investors/my_projects', [DashboardController::class, 'my_projects'])->name('dashboard.my_projects');
        Route::get('/investors/projects_awaiting_award/award_modal/{offer_id}', [DashboardController::class, 'award_modal'])->name('project.award_modal');
        Route::get('/investors/projects_awaiting_award/contractor_award_modal/{contractor_offer_id}', [DashboardController::class, 'contractor_award_modal'])->name('project.contractor_award_modal');
        Route::post('/investors/projects/award-approval-offer/{offer_id}', [DashboardController::class, 'store_award_approval'])->name('project.award_approval_offer');
        Route::post('/investors/projects/contractor-award-approval-offer/{offer_id}', [DashboardController::class, 'store_contractor_award_approval'])->name('project.contractor_award_approval_offer');

        Route::post('/investors/smsOtp', [DashboardController::class, 'smsOtp'])->name('dashboard.smsOtp');
        Route::post('/investors/verifySmsOtp', [DashboardController::class, 'verifySmsOtp'])->name('dashboard.verifySmsOtp');

        Route::get('/investors/my_wallet', [DashboardController::class, 'my_wallet'])->name('dashboard.wallet');
        Route::post('/investors/my_wallet/deposit_requests', [DashboardController::class, 'deposit_requests'])->name('dashboard.wallet.deposit_requests');
        Route::get('/investors/my_wallet/deposit_requests', [DashboardController::class, 'deposit_requests'])->name('dashboard.wallet.deposit_requests');
        Route::get('/investors/my_wallet/transactions', [DashboardController::class, 'transactions'])->name('dashboard.wallet.transactions');
        Route::get('/investors/my_wallet/my_stock_portfolio', [DashboardController::class, 'my_stock_portfolio'])->name('dashboard.wallet.my_stock_portfolio');
        Route::get('/investors/my_wallet/get_transactions', [DashboardController::class, 'get_transactions'])->name('dashboard.wallet.get_transactions');
        Route::post('/investors/check/balance', [DashboardController::class, 'check_balance'])->name('check.balance');
        Route::post('/investors/buy/shares', [DashboardController::class, 'buy_shares'])->name('buy.shares');



        Route::get('/investors/notifications/list', [DashboardController::class, 'notifications_list'])->name('notifications.list');
        Route::post('/investors/notifications/mark-as-read/{id}', [DashboardController::class, 'markAsRead']);

        Route::get('/investors/notifications/unread', function () {
            return response()->json([
                'count' => auth('investors')->user()->unreadNotifications()->count(),
            ]);
        })->name('notifications.unread');

        Route::post('logout_investor', [LoginController::class, 'logout'])->name('logout');

    });


});




