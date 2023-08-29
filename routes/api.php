<?php

use App\Http\Controllers\Api\CompanyBranchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\LeadController;
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


    Route::middleware('check_default_company')->group( function(){

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

                    Route::get('{token:token}/invitation', [MemberController::class, 'getInvitation'])->withoutMiddleware('check_default_company')->name('view_invitation');
                    Route::post('{member:token}/accept-invitation', [MemberController::class, 'acceptInvitation'])->withoutMiddleware('check_default_company')->name('accept_invitation');

                    Route::get('/lists', [MemberController::class, 'index'])
                                    ->middleware('permission:Member List')
                                    ->name('index');

                    Route::get('{member}/edit', [MemberController::class, 'edit'])
                                    ->middleware('permission:Update Member')
                                    ->name('edit');

                    Route::post('store', [MemberController::class, 'store'])
                                    ->middleware('permission:Add Member|Update Member')
                                    ->name('store');

                    Route::post('{member}/delete', [MemberController::class, 'delete'])
                                    ->middleware('permission:Remove Member')
                                    ->name('delete');

                    Route::get('roles', [MemberController::class, 'getRoles'])
                                    ->name('members_roles_list');

                });

        Route::prefix('branches')
                ->name('company_branch.')
                ->group( function () {

                    Route::get('/lists', [CompanyBranchController::class, 'index'])
                                    ->middleware('permission:Branch List')
                                    ->name('index');

                    Route::get('{branch}/edit', [CompanyBranchController::class, 'edit'])
                                    ->middleware('permission:Update Branch')
                                    ->name('edit');

                    Route::post('store', [CompanyBranchController::class, 'store'])
                                    ->middleware('permission:Add Branch|Update Branch')
                                    ->name('store');

                    // Route::post('{branch}/delete', [CompanyBranchController::class, 'delete'])
                    //                 ->middleware('permission:Remove Branch')
                    //                 ->name('delete');

                });

        Route::prefix('contacts')
                ->name('contact.')
                ->group( function () {

                    Route::get('/lists', [ContactController::class, 'index'])
                                    ->middleware('permission:Contact List')
                                    ->name('index');

                    Route::get('{contact}/edit', [ContactController::class, 'edit'])
                                    ->middleware('permission:Update Contact')
                                    ->name('edit');

                    Route::post('store', [ContactController::class, 'store'])
                                    ->middleware('permission:Add Contact|Update Contact')
                                    ->name('store');

                    // Route::post('{contact}/delete', [ContactController::class, 'delete'])
                    //                 ->middleware('permission:Remove Contact')
                    //                 ->name('delete');

                    Route::get('contact-types/select-list', [ ContactController::class, 'contactTypeSelectList'])
                                    ->name('select.contact_types');

                    Route::get('customer-types/select-list', [ ContactController::class, 'customerTypeSelectList'])
                                    ->name('select.customer_types');
                });

        Route::prefix('leads')
                ->name('lead.')
                ->group( function () {

                    Route::get('/lists', [LeadController::class, 'index'])
                                    ->middleware('permission:Lead List|Only Assigned Lead List')
                                    ->name('index');

                    Route::get('{lead}/edit', [LeadController::class, 'edit'])
                                    ->middleware('permission:Update Lead')
                                    ->name('edit');

                    Route::get('{lead}/view', [LeadController::class, 'view'])
                                    ->middleware('permission:View Lead')
                                    ->name('view');

                    Route::post('store', [LeadController::class, 'store'])
                                    ->middleware('permission:Add Lead|Update Lead')
                                    ->name('store');

                    Route::post('{lead}/add-comment', [LeadController::class, 'addLeadComment'])
                                    ->middleware('permission:Update Lead')
                                    ->name('add.lead_comment');

                    // Route::post('{lead}/delete', [LeadController::class, 'delete'])
                    //                 ->middleware('permission:Remove Lead')
                    //                 ->name('delete');

                    Route::get('lead-source/select-list', [ LeadController::class, 'leadSourceSelectList'])
                                    ->name('select.lead_source');

                    Route::get('lead-status/select-list', [ LeadController::class, 'leadStatusSelectList'])
                                    ->name('select.lead_status');

                    Route::get('company-branch/select-list', [ LeadController::class, 'companyBranchSelectList'])
                                    ->name('select.company_banch');
                    Route::get('company-members/select-list', [ LeadController::class, 'companyMembersSelectList'])
                                    ->name('select.company_member');
                });

    });

});
