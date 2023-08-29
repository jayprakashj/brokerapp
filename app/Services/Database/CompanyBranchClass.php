<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\CompanyBranch;

class CompanyBranchClass {

    public function getDefaultCompanyBranches ( $perPage = 24 ) {
        $branches = CompanyBranch::with('company')->paginate( $perPage );
        return $branches;
    }

    public function defaultCompanyBranchSelectList () {
        $branches = CompanyBranch::with('company')->get();
        return $branches;
    }


    public function create ( User $user, $request ) {

        $companyBranch = new CompanyBranch();
        $companyBranch->user_id = $user->id;
        $companyBranch->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $companyBranch->created_by = $user->id;
        $companyBranch = $this->createOrUpdate( $companyBranch, $user, $request );


        return $companyBranch;
    }

    public function update ( User $user, CompanyBranch $companyBranch, $request ){
        return $this->createOrUpdate( $companyBranch, $user, $request );
    }

    public function createOrUpdate( CompanyBranch $branch, User $user, $request ){
        $branch->name = $request->input('name');
        $branch->mobile = $request->input('mobile');
        $branch->email = $request->input('email');
        $branch->address = $request->input('address');
        $branch->city = $request->input('city');
        $branch->state = $request->input('state');
        $branch->updated_by = $user->id;
        $branch->save();


        return $branch;
    }

}
