<?php

use App\Http\Controllers\Api\CompanyBranchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DashboardController as ApiDashboardController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\RoleManagementController;
use App\Http\Controllers\Api\SiteVisitController;
use App\Http\Controllers\Api\TaskController;
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
        Route::get('/data/dashboard', [ApiDashboardController::class, 'getDashboardData'])
                                                ->name('data.dashboard');
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
                    Route::get('filter-data', [RoleManagementController::class, 'getFilterData'])
                            ->name('filter_data');

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

                    Route::get('filter-data', [MemberController::class, 'getFilterData'])
                                            ->name('filter_data');

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
                                    ->middleware('permission:Can Comment')
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


        Route::prefix('properties')
        ->name('property.')
        ->group( function () {

            Route::get('/lists', [PropertyController::class, 'index'])
                            ->middleware('permission:Property List|Only Assigned Property List')
                            ->name('index');

            Route::get('{property}/edit', [PropertyController::class, 'edit'])
                            ->middleware('permission:Update Property')
                            ->name('edit');

            Route::get('{property}/view', [PropertyController::class, 'view'])
                            ->middleware('permission:View Property')
                            ->name('view');

            Route::post('store', [PropertyController::class, 'store'])
                            ->middleware('permission:Add Property|Update Property')
                            ->name('store');

            Route::get('{property}/documents', [PropertyController::class, 'getDocumentList'])
                            ->middleware('permission:Document Attach to Property')
                            ->name('document_lists');

            Route::get('{property}/documents/select-lists', [PropertyController::class, 'getDocumentListForSelectList'])
                            ->middleware('permission:Document Attach to Property')
                            ->name('document.select_lists');


            Route::get('lists/form-select-lists', [PropertyController::class, 'createFormSelectList'])
                            ->name('create_form_lists');

            Route::get('select-lists/get', [PropertyController::class, 'getPropertyForSelectList'])
                            ->name('get_select_lists');

            Route::get('filter-data', [PropertyController::class, 'getPropertyFilterData'])
                            ->name('filter_data');

            // Route::post('{Property}/delete', [PropertyController::class, 'delete'])
            //                 ->middleware('permission:Remove Property')
            //                 ->name('delete');
        });

        Route::prefix('documents')
        ->name('document.')
        ->group( function () {

            Route::get('/lists', [DocumentController::class, 'index'])
                            ->middleware('permission:Document List')
                            ->name('index');

            Route::get('{document}/edit', [DocumentController::class, 'edit'])
                            ->middleware('permission:Update Document')
                            ->name('edit');

            Route::post('store', [DocumentController::class, 'store'])
                            ->middleware('permission:Add Document|Update Document')
                            ->name('store');

            Route::post('attach-property', [DocumentController::class, 'attachDocument'])
                                ->middleware('permission:Document Attach to Property')
                                ->name('attach_property');
            Route::post('{document}/detach-property', [DocumentController::class, 'deletePropertyDocument'])
                                ->middleware('permission:Document Attach to Property')
                                ->name('detach_property');
            // Route::post('{document}/delete', [DocumentController::class, 'delete'])
            //                 ->middleware('permission:Remove Document')
            //                 ->name('delete');

        });

        Route::prefix('projects')
        ->name('project.')
        ->group( function () {

            Route::get('/lists', [ProjectController::class, 'index'])
                            ->middleware('permission:Project List|Only Assigned Project List')
                            ->name('index');

            Route::get('{project}/edit', [ProjectController::class, 'edit'])
                            ->middleware('permission:Update Project')
                            ->name('edit');

            Route::get('{project}/view', [ProjectController::class, 'view'])
                            ->middleware('permission:View Project')
                            ->name('view');

            Route::post('store', [ProjectController::class, 'store'])
                            ->middleware('permission:Add Project|Update Project')
                            ->name('store');

            Route::get('lists/form-select-lists', [ProjectController::class, 'createFormSelectList'])
                            ->name('create_form_lists');

            Route::get('select-lists/get', [ProjectController::class, 'getProjectForSelectList'])
                                ->name('get_select_lists');
            // Route::post('{project}/delete', [ProjectController::class, 'delete'])
            //                 ->middleware('permission:Remove Project')
            //                 ->name('delete');
        });

        Route::prefix('tasks')
        ->name('task.')
        ->group( function () {

            Route::get('/lists', [TaskController::class, 'index'])
                            ->middleware('permission:Task List|Only Assigned Task List')
                            ->name('index');

            Route::get('{task}/edit', [TaskController::class, 'edit'])
                            ->middleware('permission:Update Task')
                            ->name('edit');

            Route::get('{task}/view', [TaskController::class, 'view'])
                            ->middleware('permission:View Task')
                            ->name('view');

            Route::post('store', [TaskController::class, 'store'])
                            ->middleware('permission:Add Task|Update Task')
                            ->name('store');

            Route::get('statuses/select-lists', [TaskController::class, 'taskStatusSelectList'])
                            ->name('task_status_select_list');
            // Route::post('{task}/delete', [TaskController::class, 'delete'])
            //                 ->middleware('permission:Remove Task')
            //                 ->name('delete');
        });

        Route::prefix('site-visits')
        ->name('site_visit.')
        ->group( function () {

            Route::get('/lists', [SiteVisitController::class, 'index'])
                            ->middleware('permission:Site Visit List|Only Assigned Site Visit List')
                            ->name('index');

            Route::get('{siteVisit}/edit', [SiteVisitController::class, 'edit'])
                            ->middleware('permission:Update Site Visit')
                            ->name('edit');

            Route::get('{siteVisit}/view', [SiteVisitController::class, 'view'])
                            ->middleware('permission:View Site Visit')
                            ->name('view');

            Route::post('store', [SiteVisitController::class, 'store'])
                            ->middleware('permission:Add Site Visit|Update Site Visit')
                            ->name('store');
            Route::get('lists/form-select-lists', [SiteVisitController::class, 'createFormSelectList'])
                            ->name('create_form_lists');
            // Route::post('{siteVisit}/delete', [SiteVisitController::class, 'delete'])
            //                 ->middleware('permission:Remove Task')
            //                 ->name('delete');
        });

    });

});
