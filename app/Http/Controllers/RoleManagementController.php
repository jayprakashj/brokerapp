<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\RoleCreateRequest;
use App\Models\Company;
use App\Models\SpatiePermission;
use App\Services\Database\RoleClass;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    private $roleClass;

    public function __construct( RoleClass $roleClass )
    {
        $this->roleClass = $roleClass;
    }

    public function index () {
        $menus = [
            [
                'title' => 'Create',
                'icon_class' => 'fa-plus',
                'link' => route('role.create')
            ]
        ];
        $roles = $this->roleClass->getAllAuthUserRoles();

        $data = compact( 'menus', 'roles' );
        return view('role-management.index', $data);
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

}
