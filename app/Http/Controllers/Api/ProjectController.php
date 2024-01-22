<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\AddProjectRequest;
use App\Http\Resources\Api\Project\ProjectEditResource;
use App\Http\Resources\Api\Project\ProjectPaginationResource;
use App\Http\Resources\Api\Project\ProjectViewResource;
use App\Http\Resources\Api\Property\PropertyImageTypeListForSelectList;
use App\Models\CompanyBranch;
use App\Models\Project;
use App\Models\PropertyImageTypeList;
use App\Models\User;
use App\Services\Database\ProjectClass;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $projectClass;

    public function __construct( )
    {
        $this->projectClass = new ProjectClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();
        $onlyAssignedTo = $user->can('Only Assigned Property List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $list = $this->projectClass->getDefaultCompanyProjects( $request, $onlyAssignedTo );
        return new ProjectPaginationResource( $list );
    }

    public function edit (Project $project ) {
        if( !$project->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        $project->load([
            'media',
            'assignToUser',
            'companyBranch',
            'projectTowers',
            'projectPlans',
            'projectCharges',
        ]);
        return new ProjectEditResource( $project );
    }

    public function view (Project $project ) {
        if( !$project->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        $project->load([
            'latestSiteVisits' => function ( $q ){
                $q->with([
                    'companyBranch',
                    'sourceManagerUser',
                    'closingManagerUser',
                    'createdUser',
                    'updatedUser'
                ]);
            },
            'latestLeads.lastComment'
        ]);
        return new ProjectViewResource( $project );
    }

    public function store (AddProjectRequest $request ) {
        $response = [
            'message' => 'Success! New Project added successfully.'
        ];
        $code = 200;

        $project = Project::find( $request->input('id') );

        if( is_null( $project ) ){
            $this->projectClass->create( auth()->user(), $request );

        }else{
            if( !$project->checkAuthorization() ){
                return response()->json( [], 404 );
            }
            $this->projectClass->update( auth()->user(), $project, $request );
            $response = [
                'message' => 'Success! Project data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Project $project ) {
        if( !$project->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        $code = 500;
        $project->delete();
        $response = [
            'message' => 'Project removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function createFormSelectList ( Request $request ){
        $propertyImgTypes = PropertyImageTypeList::select('id', 'name')->get();
        $projectTypes = \Helper::convertArrayIntoAssociative(Project::PROJECT_TYPES);

        $data = [
            'property_img_types' => PropertyImageTypeListForSelectList::collection( $propertyImgTypes ),
            'project_types' => $projectTypes,
        ];
        return response()->json( $data, 200 );
    }


    public function getProjectForSelectList(){
        $list = Project::select('id', 'title as name')->get();
        return response()->json( $list, 200 );
    }

    public function getFilterData ( Request $request ){
        $members = User::select('id', 'name')->get();
        $companyBranch = CompanyBranch::select('id', 'name')->get();

        $data = [
            'members' => $members,
            'company_branches' => $companyBranch,

        ];
        return response()->json( $data, 200 );
    }
}
