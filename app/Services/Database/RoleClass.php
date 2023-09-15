<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\CompanyUserPivot;
use App\Models\User;
use Helper;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleClass {

    public function getAllAuthUserRoles ( $perPage = 24 ) {
        return Role::with(['permissions'])
                        ->withCount('users')
                        ->where('company_id', Helper::retrieveDefaultCompany()->id )
                        ->paginate( $perPage );
    }


    public function create ( User $user, $request, $default = false ) {

        $role = new Role();
        $role = $this->createOrUpdate( $role, $user, $request );

        return $role;
    }

    public function update ( User $user, Role $role, $request ){
        return $this->createOrUpdate( $role, $user, $request );
    }

    private function createOrUpdate( Role $role, User $user, $request ){
        $role->name = $request->input('role_name');
        $role->user_id = $user->id;
        $role->company_id = \Helper::retrieveDefaultCompany()->id;
        $role->guard_name = 'web';
        $role->save();

        $permissions = Permission::whereIn('id', $request->input('permissions', []) )->get();

        $role->syncPermissions( $permissions );

        return $role;
    }
}
