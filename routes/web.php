<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoleManagementController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/login');

Route::middleware('guest')->group( function () {
    Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'viewRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/verify', [AuthController::class, 'verifyEmail'])->name('verify');

    Route::get('/forgot-password', [AuthController::class, 'viewForgotPassword'])->name('forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetPasswordLink'])->name('forgot_password');

    Route::get('/reset-password/{token}', [AuthController::class, 'viewResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset_password');

});


Route::middleware(['auth', 'set_default_company'])->group( function (){
    Route::get('{any?}/{slug?}/{id?}', [ DashboardController::class, 'loadVueApp'])->name('vue_app');
});
