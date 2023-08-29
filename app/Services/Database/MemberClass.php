<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Models\CompanyMember;
use App\Models\CompanyUserPivot;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Mail\SendUserInvitationMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;

class MemberClass {

    // private $userClass;

    // public function __construct( UserClass $userClass )
    // {
    //     $this->userClass = $userClass;
    // }
    public function getDefaultCompanyMembers ( $perPage = 24 ) {
        $members = CompanyMember::with([
                            'memberUser',
                            'role'
                        ])->currentDefaultCompany()
                        ->paginate( $perPage );
        return $members;
    }

    public function getMembersListForSelectList () {
        $members = CompanyMember::with('memberUser')->currentDefaultCompany()->get();
        return $members;
    }


    public function create ( User $user, $request ) {

        $companyMember = new CompanyMember();
        $companyMember->invite_status = CompanyMember::INVITE_STATUS_PENDING;
        $companyMember->token = $this->generateUniqueToken();
        $member = $this->createOrUpdate( $companyMember, $user, $request );

        $this->sendInvitation( $member );

        return $member;
    }

    public function update ( User $user, CompanyMember $companyMember, $request ){
        return $this->createOrUpdate( $companyMember, $user, $request );
    }

    public function acceptInvitation ( CompanyMember $companyMember ){
        $companyMember->invite_status = CompanyMember::INVITE_STATUS_ACCEPT;
        $companyMember->token = null;
        $companyMember->user_id = auth()->id();
        $companyMember->save();

        setPermissionsTeamId( $companyMember->company_id );
        auth()->user()->assignRole( $companyMember->role_id );

        return $companyMember;
    }

    public function createWithUserRegistration ( Company $company, User $user, $isDefault = 0, $inviteStatus = 0 ) {
        $member = new CompanyMember();
        $member->email = $user->email;
        $member->user_id = $user->id ?? null;
        $member->company_id = $company->id;
        $member->role_id = $user->globalRole->first()->id;
        $member->created_by = $user->id;
        $member->is_default = $isDefault;
        $member->invite_status = $inviteStatus;
        $member->is_owner = CompanyMember::FLAG_IS_OWNER_YES;
        $member->save();

        return $member;
    }


    public function createOrUpdate( CompanyMember $member, User $user, $request ){
        $email = $request->input('email');
        $emailUser = User::whereEmail( $email )->first();
        $member->email = $request->input('email');
        $member->user_id = $emailUser->id ?? null;
        $member->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $member->role_id = $request->input('role');
        $member->created_by = $user->id;
        $member->is_owner = CompanyMember::FLAG_IS_OWNER_NO;
        $member->save();


        return $member;
    }

    public function changeWhenInvitationAccepted( CompanyMember $member, $request ){
        $member->role_id = $request->input('role');
        $member->save();


        return $member;
    }

    public function changeWhenInvitationPending( CompanyMember $member, $request ){
        $email = $request->input('email');
        $emailUser = User::whereEmail( $email )->first();
        $member->email = $request->input('email');
        $member->user_id = $emailUser->id ?? null;
        $member->role_id = $request->input('role');
        $member->token = $this->generateUniqueToken();
        $member->save();

        $this->sendInvitation( $member );

        return $member;
    }

    public function sendInvitation ( CompanyMember $companyMember ) {
        Mail::to( $companyMember->email )->send( new SendUserInvitationMail( $companyMember ) );
    }

    public function generateUniqueToken ( $token = null ) {
        if( is_null( $token ) ){
            $token = Str::random( 28 );
        }
        $exists = CompanyMember::whereToken( $token )->first();
        if( !is_null( $exists ) ){
            return $this->generateUniqueToken();
        }
        return $token;
    }
}
