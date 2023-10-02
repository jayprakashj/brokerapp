<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Resources\Api\Member\InvitationDataResource;
use App\Http\Resources\Api\Member\MemberEditResource;
use App\Http\Resources\Api\Member\MemberPaginationResource;
use App\Http\Resources\Api\Member\RolesListResource;
use App\Models\CompanyBranch;
use App\Models\CompanyMember;
use App\Models\Role;
use App\Services\Database\MemberClass;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $memberClass;

    public function __construct( MemberClass $memberClass )
    {
        $this->memberClass = $memberClass;
    }

    public function index ( Request $request ) {

        $members = $this->memberClass->getDefaultCompanyMembers( $request );

        return new MemberPaginationResource( $members );
    }

    public function edit (CompanyMember $member ) {

        return new MemberEditResource( $member );
    }

    public function store (AddMemberRequest $request ) {
        $response = [
            'message' => 'Success! Member created successfully.'
        ];
        $code = 200;

        $member = CompanyMember::find( $request->input('id') );

        if( is_null( $member ) ){
            $this->memberClass->create( auth()->user(), $request );

        }else{
            if( $member->user_id !== auth()->id() ){

                $this->memberClass->update(  auth()->user(), $member, $request );
                $response = [
                    'message' => 'Success! Member updated changed successfully.'
                ];
            }else{
                $code = 500;
                $response = [
                    'message' => 'Oops! Invalid request.'
                ];

            }
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
        $code = 500;
        if( !$member->isMe() && !$member->isOwner() ){

            $member->delete();
            $response = [
                'message' => 'Member removed successfully.'
            ];
            $code = 200;
        }else{
            $response = [
                'message' => 'Oops! Invalid action.'
            ];

        }
        return response()->json( $response , $code);
    }

    public function getFilterData ( Request $request ){
        $roles = Role::select('id', 'name')->get();
        $companyBranch = CompanyBranch::select('id', 'name')->get();

        $data = [
            'roles' => $roles,
            'company_branches' => $companyBranch,

        ];
        return response()->json( $data, 200 );
    }
}
