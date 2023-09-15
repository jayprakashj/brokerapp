<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\AddContactRequest;
use App\Http\Requests\Api\Lead\AddLeadCommentRequest;
use App\Http\Requests\Api\Lead\AddLeadRequest;
use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use App\Http\Resources\Api\Contact\ContactEditResource;
use App\Http\Resources\Api\Contact\ContactPaginationResource;
use App\Http\Resources\Api\Lead\LeadEditResource;
use App\Http\Resources\Api\Lead\LeadPaginationResource;
use App\Http\Resources\Api\Lead\LeadViewResource;
use App\Http\Resources\Api\Member\MemberSelectListResource;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Services\Database\CompanyBranchClass;
use App\Services\Database\MemberClass;
use App\Services\Database\ContactClass;
use App\Services\Database\ContactTypeClass;
use App\Services\Database\CustomerTypeClass;
use App\Services\Database\LeadClass;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private $leadClass;
    private $companyBranchClass;
    private $memberClass;

    public function __construct( )
    {
        $this->leadClass = new LeadClass;
        $this->companyBranchClass = new CompanyBranchClass;
        $this->memberClass = new MemberClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();

        $onlyAssignedTo = $user->can('Only Assigned Lead List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $branches = $this->leadClass->getDefaultCompanyLeads( $request->input('per_page', 24 ), $onlyAssignedTo);
        return new LeadPaginationResource( $branches );
    }

    public function edit (Lead $lead ) {
        if( !$lead->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        return new LeadEditResource( $lead );
    }

    public function view (Lead $lead ) {

        if( !$lead->checkAuthorization() ){
            return response()->json( [], 404 );
        }

        return new LeadViewResource( $lead );
    }

    public function store (AddLeadRequest $request ) {
        $response = [
            'message' => 'Success! New Lead added successfully.'
        ];
        $code = 200;

        $lead = Lead::find( $request->input('id') );

        if( is_null( $lead ) ){
            $this->leadClass->create( auth()->user(), $request );

        }else{

            if( !$lead->checkAuthorization() ){
                return response()->json( [], 404 );
            }
            $this->leadClass->update( auth()->user(), $lead, $request );
            $response = [
                'message' => 'Success! Lead data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Lead $lead ) {
        $code = 500;
        $lead->delete();
        $response = [
            'message' => 'Lead removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function addLeadComment ( Lead $lead, AddLeadCommentRequest $request ) {
        // $code = 500;

        if( !$lead->checkAuthorization() ){
            return response()->json( [], 404 );
        }

        $this->leadClass->updateLeadFollowup( $lead, auth()->user(), $request );
        $response = [
            'message' => 'Lead comment added successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function leadSourceSelectList ( Request $request ){
        $list = LeadSource::select('id', 'name')->get();
        return response()->json( $list, 200 );
    }

    public function leadStatusSelectList ( Request $request ){
        $list = LeadStatus::select('id', 'name')->get();
        return response()->json( $list, 200 );
    }

    public function companyBranchSelectList ( Request $request ){
        $list = $this->companyBranchClass->defaultCompanyBranchSelectList();
        return BranchListForSelectList::collection( $list );
    }

    public function companyMembersSelectList ( Request $request ){
        $list = $this->memberClass->getMembersListForSelectList();
        return MemberSelectListResource::collection( $list );
    }
}
