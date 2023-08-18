<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\CompanyUserPivot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class CompanyClass {

    private $memberClass;

    public function __construct()
    {
        $this->memberClass = new MemberClass();
    }


    public function create ( User $user, $request, $default = false ) {

        $company = new Company();

        $company->owned_by = $user->id;

        $company = $this->createOrUpdate( $company, $user, $request, $default );

        $member = $this->memberClass->createWithUserRegistration( $company, $user, CompanyMember::FLAG_IS_DEFAULT_NO, CompanyMember::INVITE_STATUS_ACCEPT );

        setPermissionsTeamId( $company->id );
        $user->assignRole( $member->role_id );

        return $company;
    }

    public function update ( User $user, Company $company, $request ){
        return $this->createOrUpdate( $company, $user, $request );
    }


    public function detachCompanyWithUser ( User $user, Company $company ){
        CompanyMember::where('company_id',$company->id)
                        ->where('user_id', $user->id)
                        ->delete();
    }

    public function detachCompanyWithManyUser ( array $user, Company $company ){
        CompanyMember::where('company_id',$company->id)
                        ->whereIn('user_id', $user)
                        ->delete();
    }


    public function makeDefault ( Company $company, User $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        CompanyMember::where('user_id', $user->id )
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
        $company->name = $request->input('company_name');
        $company->pan_no = $request->input('pan_no');
        $company->gst_no = $request->input('gst_no');
        $company->email = $request->input('email');
        $company->mobile = $request->input('mobile');
        if( $company->id && !$company->isDefault() ){
            $company->status = $request->input('status');
        }
        $company->save();
        if( $request->has('logo') ){
            $logoFile = 'tmp_media/' . $request->input('logo');
            if( Storage::disk('public')->has( $logoFile ) ){
                $company->addMediaFromDisk( $logoFile, 'public')->toMediaCollection('logo');
            }
        }
        return $company;
    }

    public function createWithUserRegistration( Company $company, User $user, $request ){
        $company->owned_by = $user->id;
        $company->name = $request->input('company_name');
        $company->email = $user->email;
        $company->mobile = $user->mobile;
        if( $company->id && !$company->isDefault() ){
            $company->status = $request->input('status');
        }
        $company->save();
        return $company;
    }
}
