<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SiteVisit\AddSiteVisitRequest;
use App\Http\Resources\Api\Member\MemberSelectListResource;
use App\Http\Resources\Api\SiteVisit\SiteVisitEditResource;
use App\Http\Resources\Api\SiteVisit\SiteVisitPaginationResource;
use App\Http\Resources\Api\SiteVisit\SiteVisitViewResource;
use App\Models\CompanyBranch;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Property;
use App\Models\SiteVisit;
use App\Models\User;
use App\Services\Database\MemberClass;
use App\Services\Database\SiteVisitClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteVisitController extends Controller
{
    private $siteVisitClass;
    private $memberClass;

    public function __construct( )
    {
        $this->siteVisitClass = new SiteVisitClass;
        $this->memberClass = new MemberClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();

        $onlyAssignedTo = $user->can('Only Assigned Site Visit List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $branches = $this->siteVisitClass->getDefaultCompanySiteVisits( $request, $onlyAssignedTo);
        return new SiteVisitPaginationResource( $branches );
    }

    public function edit (SiteVisit $siteVisit ) {
        if( !$siteVisit->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        return new SiteVisitEditResource( $siteVisit );
    }

    public function view (SiteVisit $siteVisit ) {

        if( !$siteVisit->checkAuthorization() ){
            return response()->json( [], 404 );
        }

        return new SiteVisitViewResource( $siteVisit );
    }

    public function store (AddSiteVisitRequest $request ) {
        $response = [
            'message' => 'Success! New Site Visit added successfully.'
        ];
        $code = 200;

        $siteVisit = SiteVisit::find( $request->input('id') );

        if( is_null( $siteVisit ) ){
            $this->siteVisitClass->create( auth()->user(), $request );

        }else{

            if( !$siteVisit->checkAuthorization() ){
                return response()->json( [], 404 );
            }
            $this->siteVisitClass->update( auth()->user(), $siteVisit, $request );
            $response = [
                'message' => 'Success! Site Visit data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( SiteVisit $siteVisit ) {
        $code = 500;
        $siteVisit->delete();
        $response = [
            'message' => 'Site Visit removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function createFormSelectList ( Request $request ){
        $propertyList = Property::select('id', 'name')->get();
        $projectList = Project::select('id', 'title as name')->get();
        $companyBranch = CompanyBranch::select('id', 'name')->get();
        $members = $this->memberClass->getMembersListForSelectList();
        $leads = Lead::select(
                            'id',
                            DB::raw( 'CONCAT( title, " / ", customer_name, " / ", customer_mobile, " / ", customer_email ) as name' )
                        )
                        ->workingLead()
                        ->orderBy('name')
                        ->get();
        $visitTypes = SiteVisit::VISIT_TYPES;
        $types =  SiteVisit::TYPES;

        $data = [
            'properties' => $propertyList,
            'projects' => $projectList,
            'members' => MemberSelectListResource::collection( $members ),
            'company_branches' => $companyBranch,
            'visit_types' => $visitTypes,
            'types' => $types,
            'leads' => $leads,
        ];
        return response()->json( $data, 200 );
    }

    public function getFilterData ( Request $request ){
        $members = User::select('id', 'name')->get();
        $companyBranch = CompanyBranch::select('id', 'name')->get();
        $properties = Property::select('id', 'name')->get();
        $projects = Project::select('id', 'title as name')->get();

        $data = [
            'members' => $members,
            'company_branches' => $companyBranch,
            'properties' => $properties,
            'projects' => $projects,
            'visit_types' => SiteVisit::VISIT_TYPES,
            'types' => SiteVisit::TYPES,

        ];
        return response()->json( $data, 200 );
    }


}
