<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
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

Route::get('/', function () {
    return view('welcome');
});
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


Route::middleware('auth')->group( function (){
    Route::get('dashboard', [DashboardController::class, 'viewDashboard'])->name('dashboard');

    Route::prefix('company')
            ->name('company.')
            ->group( function () {
                Route::get('/', [CompanyController::class, 'index'])->name('index');
                Route::get('create', [CompanyController::class, 'create'])->name('create');
                Route::get('{company}/set-default', [CompanyController::class, 'makeDefault'])->name('set_default');
                Route::get('{company}/change-status', [CompanyController::class, 'changeStatus'])->name('change_status');
                Route::get('{company}/edit', [CompanyController::class, 'create'])->name('edit');
                Route::post('store', [CompanyController::class, 'store'])->name('store');

            });

    Route::prefix('roles')
            ->name('role.')
            ->group( function () {
                Route::get('/', [RoleManagementController::class, 'index'])->name('index');
                Route::get('create', [RoleManagementController::class, 'create'])->name('create');
                Route::get('{company}/edit', [RoleManagementController::class, 'create'])->name('edit');
                Route::post('store', [RoleManagementController::class, 'store'])->name('store');
                Route::post('delete', [RoleManagementController::class, 'delete'])->name('delete');

            });
});
