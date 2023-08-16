<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Resources\Api\Member\InvitationDataResource;
use App\Http\Resources\Api\Member\MemberEditResource;
use App\Http\Resources\Api\Member\MemberPaginationResource;
use App\Http\Resources\Api\Member\RolesListResource;
use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\User;
use App\Services\Database\MemberClass;

class MemberController extends Controller
{
    private $memberClass;

    public function __construct( MemberClass $memberClass )
    {
        $this->memberClass = $memberClass;
    }

    public function index () {

        $members = $this->memberClass->getDefaultCompanyMembers();

        return new MemberPaginationResource( $members );
    }

    public function edit (CompanyMember $member ) {

        return new MemberEditResource( $member );
    }

    public function store (AddMemberRequest $request ) {
        $response = [
            'message' => 'Success! Invitation sent successfully.'
        ];
        $code = 200;

        $member = CompanyMember::find( $request->input('id') );

        if( is_null( $member ) ){
            $this->memberClass->create( auth()->user(), $request );

        }else{
            $this->memberClass->update( auth()->user(), $member, $request );
            $response = [
                'message' => 'Success! User invitation updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }

    public function getRoles (){
        $roles = auth()->user()->userRoles()->get();

        return RolesListResource::collection( $roles );
    }

    public function getInvitation ( CompanyMember $token ) {
        if( $token->email == auth()->user()->email  ){
            return new InvitationDataResource( $token );
        }
        return response()->json([], 404);
    }

    public function acceptInvitation ( CompanyMember $member ) {
        if( $member->email == auth()->user()->email ){
            $this->memberClass->acceptInvitation( $member );
            $data = [
                'message' => 'Success! Company attached with you successfully.'
            ];
            return response()->json( $data , 200);
        }
        return response()->json([], 404);
    }

    public function delete ( CompanyMember $member ) {
        $member->delete();
        $response = [
            'message' => 'Member removed successfully.'
        ];
        return response()->json( $response , 200);
    }
}
