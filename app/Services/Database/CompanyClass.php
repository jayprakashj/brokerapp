<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\CompanyUserPivot;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyClass {

    public function create ( User $user, $request, $default = false ) {

        $company = new Company();
        $company = $this->createOrUpdate( $company, $user, $request );

        $this->associateCompanyWithUser( $user, $company, $default );

        return $company;
    }

    public function update ( User $user, Company $company, $request ){
        return $this->createOrUpdate( $company, $user, $request );
    }

    public function associateCompanyWithUser ( User $user, Company $company, $default = false ){
        $companyUser = new CompanyUserPivot();
        $companyUser->company_id = $company->id;
        $companyUser->user_id = $user->id;
        $companyUser->is_default = $default;
        $companyUser->save();
    }

    public function detachCompanyWithUser ( User $user, Company $company ){
        CompanyUserPivot::where('company_id',$company->id)
                        ->where('user_id', $user->id)
                        ->delete();
    }

    public function detachCompanyWithManyUser ( array $user, Company $company ){
        CompanyUserPivot::where('company_id',$company->id)
                        ->whereIn('user_id', $user)
                        ->delete();
    }


    public function makeDefault ( Company $company, User $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        CompanyUserPivot::where('user_id', $user->id )
                        ->update([
                            'is_default' => DB::raw( '( company_id = '. $company->id .' )')
                        ]);
        $user->refresh();

        \Helper::setDefaultCompanySessionTeam();
    }

    public function changeStatus ( Company $company, User $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        if( $company->isActive() ){
            $company->status = Company::$STATUS_INACTIVE;
        }else{
            $company->status = Company::$STATUS_ACTIVE;

        }
        $company->save();
        $user->refresh();
    }

    private function createOrUpdate( Company $company, User $user, $request ){
        $company->owned_by = $user->id;
        $company->name = $request->input('company_name');
        $company->status = $request->input('status');
        $company->save();
        return $company;
    }
}
