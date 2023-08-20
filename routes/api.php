<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\RoleManagementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth' , 'set_default_company' ])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/upload-media', [DashboardController::class, 'uploadMedia'])->name('upload_media');

    Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('upadte_profile');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('upadte_password');

    Route::prefix('company')->group( function () {
        Route::get('/lists', [CompanyController::class, 'index'])->name('index');
        Route::post('{company}/set-default', [CompanyController::class, 'makeDefault'])->name('set_default');
        Route::post('{company}/change-status', [CompanyController::class, 'changeStatus'])->name('change_status');
        Route::get('{company}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::post('store', [CompanyController::class, 'store'])->name('store');

    });

    Route::get('/fetch/permissions', [RoleManagementController::class, 'getPermissions'])->name('fetch.permissions');

    Route::prefix('roles')
            ->name('role.')
            ->group( function () {
                Route::get('/lists', [RoleManagementController::class, 'index'])
                        ->middleware('permission:Role List')
                        ->name('index');

                Route::get('{role}/edit', [RoleManagementController::class, 'edit'])
                        ->middleware('permission:Update Role')
                        ->name('edit');

                Route::post('store', [RoleManagementController::class, 'store'])
                        ->middleware('permission:Add Role|Update Role')
                        ->name('store');

                Route::post('{role}/delete', [RoleManagementController::class, 'delete'])
                        ->middleware('permission:Remove Role')
                        ->name('delete');

            });

    Route::prefix('members')
            ->name('member.')
            ->group( function () {

                Route::get('{token:token}/invitation', [MemberController::class, 'getInvitation'])->name('view_invitation');
                Route::post('{member:token}/accept-invitation', [MemberController::class, 'acceptInvitation'])->name('accept_invitation');

                Route::middleware('check_default_company')->group( function(){

                    Route::get('/lists', [MemberController::class, 'index'])
                                    ->middleware('permission:User List')
                                    ->name('index');

                    Route::get('{member}/edit', [MemberController::class, 'edit'])
                                    ->middleware('permission:Update User')
                                    ->name('edit');

                    Route::post('store', [MemberController::class, 'store'])
                                    ->middleware('permission:Add User|Update User')
                                    ->name('store');

                    Route::post('{member}/delete', [MemberController::class, 'delete'])
                                    ->middleware('permission:Remove User')
                                    ->name('delete');

                    Route::get('roles', [MemberController::class, 'getRoles'])
                                    ->name('members_roles_list');
                });

            });

});
