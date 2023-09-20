<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SiteVisit\AddSiteVisitRequest;
use App\Http\Requests\Api\Task\AddTaskRequest;
use App\Http\Resources\Api\SiteVisit\SiteVisitEditResource;
use App\Http\Resources\Api\SiteVisit\SiteVisitPaginationResource;
use App\Http\Resources\Api\SiteVisit\SiteVisitViewResource;
use App\Http\Resources\Api\Task\TaskEditResource;
use App\Http\Resources\Api\Task\TaskPaginationResource;
use App\Http\Resources\Api\Task\TaskStatusListForSelectList;
use App\Http\Resources\Api\Task\TaskViewResource;
use App\Models\SiteVisit;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\Database\SiteVisitClass;
use App\Services\Database\TaskClass;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    private $siteVisitClass;

    public function __construct( )
    {
        $this->siteVisitClass = new SiteVisitClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();

        $onlyAssignedTo = $user->can('Only Assigned Site Visit List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $branches = $this->siteVisitClass->getDefaultCompanySiteVisits( $request->input('per_page', 24 ), $onlyAssignedTo);
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

}
