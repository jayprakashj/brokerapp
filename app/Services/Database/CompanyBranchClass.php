<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\CompanyBranch;

class CompanyBranchClass {

    public function getDefaultCompanyBranches ( $request ) {
        $branches = CompanyBranch::with(['company', 'updatedUser'])
                            ->customFilter( $request->input('filter') )
                            ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                            ->paginate( $request->input('per_page', config('app.per_page') ) );
        return $branches;
    }

    public function defaultCompanyBranchSelectList () {
        $branches = CompanyBranch::with('company')->get();
        return $branches;
    }


    public function create ( User $user, $request ) {

        $companyBranch = new CompanyBranch();
        $companyBranch->user_id = \Helper::retrieveDefaultCompany()->owned_by;
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
