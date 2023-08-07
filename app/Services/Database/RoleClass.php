<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\CompanyUserPivot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleClass {

    public function getAllAuthUserRoles () {
        return Role::where('user_id', auth()->id() )
                        ->paginate( 10 );
    }
}
