<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Models\Company;
use App\Models\SpatiePermission;
use App\Services\Database\CompanyClass;
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

            $title = 'Update Role';
        }else{
            $title = 'Create Role';

        }
        $permissions = SpatiePermission::with('subPermissions')->groupBy('group_name')->get();

        return view('role-management.create', compact('breadcrumbs', 'title', 'role', 'permissions') );
    }

    public function store (CompanyCreateRequest $request ) {
        $message = 'Success! Role created successfully.';
        $role = Role::find( $request->input('id') );
        $request->merge([
            'status' => $request->has('status')
        ]);
        if( is_null( $role ) ){
            $this->companyClass->create( auth()->user(), $request );

        }else{
            $message = 'Success! Company updated successfully.';
            $this->companyClass->update( auth()->user(), $role, $request );

        }
        return redirect()->route('company.index')->with('success-message', $message);
    }

    public function makeDefault ( Company $company ){
        if( $company->isActive() )
        {
            $this->companyClass->makeDefault( $company );
            return redirect()->route('company.index')->with('success-message', 'Success! Default company changed to '.$company->name.'.');
        }else{
            return redirect()->bcvk()->with('error-message', 'Error! Company must be active to cmake the default.');

        }
    }

    public function changeStatus ( Company $company ){
        if( !$company->isDefault() )
        {
            $this->companyClass->changeStatus( $company );
            return redirect()->route('company.index')->with('success-message', 'Success! Company with name '.$company->name.' status has been changed successfully.');
        }else{
            return redirect()->bcvk()->with('error-message', 'Error! Default company can not change the status.');

        }
    }
}
