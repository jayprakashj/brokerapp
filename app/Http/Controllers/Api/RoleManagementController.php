<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Resources\Api\Permission\GroupPermissionListResource;
use App\Http\Resources\Api\Role\RoleEditResource;
use App\Http\Resources\Api\Role\RolePaginationResource;
use App\Models\Company;
use App\Models\SpatiePermission;
use App\Services\Database\RoleClass;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    private $roleClass;

    public function __construct( )
    {
        $this->roleClass = new RoleClass;
    }

    public function index ( Request $request ) {
        $roles = $this->roleClass->getAllAuthUserRoles( $request->input('per_page', 10));

        return new RolePaginationResource( $roles );
    }

    public function create (Role $role ) {
        $breadcrumbs = [
            [
                'title' => 'Role Management',
                'link' => route('role.index')
            ],
            [
                'title' => ($role->id? 'Update' : 'Create'),
            ]
        ];
        if( $role->id ){
            $role->load('permissions');
            $title = 'Update Role';
        }else{
            $title = 'Create Role';

        }
        $permissions = SpatiePermission::with('subPermissions')->groupBy('group_name')->get();

        return view('role-management.create', compact('breadcrumbs', 'title', 'role', 'permissions') );
    }

    public function edit (Role $role ) {
        $role->load('permissions');

        return new RoleEditResource( $role );
    }

    public function store (RoleCreateRequest $request ) {
        $message = 'Success! Role created successfully.';
        $role = Role::find( $request->input('id') );
        $request->merge([
            'status' => $request->has('status')
        ]);
        try{

            if( is_null( $role ) ){
                $this->roleClass->create( auth()->user(), $request );

            }else{
                $message = 'Success! Role updated successfully.';
                $this->roleClass->update( auth()->user(), $role, $request );
            }
        }catch( \Exception $e ){
            dd( $e );
        }
        return redirect()->route('role.index')->with('success-message', $message);
    }

    public function getPermissions () {
        $permissions = SpatiePermission::with('subPermissions')->groupBy('group_name')->get();

        return GroupPermissionListResource::collection( $permissions );
    }

    public function delete ( Role $role ) {
        $code = 500;
        $role->loadCount('users');
        if( $role->users_count == 0 ){

            $role->delete();
            $response = [
                'message' => 'Role removed successfully.'
            ];
            $code = 200;
        }else{
            $response = [
                'message' => 'Oops! There are member assigned with this role.'
            ];

        }
        return response()->json( $response , $code);
    }
}
