<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\AddProjectRequest;
use App\Http\Resources\Api\Project\ProjectEditResource;
use App\Http\Resources\Api\Project\ProjectPaginationResource;
use App\Http\Resources\Api\Project\ProjectViewResource;
use App\Http\Resources\Api\Property\PropertyImageTypeListForSelectList;
use App\Models\Project;
use App\Models\PropertyImageTypeList;
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
        $list = $this->projectClass->getDefaultCompanyProjects( $request->input('per_page', 24 ), $onlyAssignedTo );
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
            'siteVisits' => function ( $q ){
                $q->with([
                    'companyBranch',
                    'sourceManagerUser',
                    'closingManagerUser',
                    'createdUser',
                    'updatedUser'
                ]);
            }
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

        $data = [
            'property_img_types' => PropertyImageTypeListForSelectList::collection( $propertyImgTypes ),
        ];
        return response()->json( $data, 200 );
    }


    public function getProjectForSelectList(){
        $list = Project::select('id', 'name')->get();
        return response()->json( $list, 200 );
    }
}
