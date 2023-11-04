<?php

namespace App\Services\Database;

use App\Models\Project;
use App\Models\ProjectCharge;
use App\Models\ProjectPlan;
use App\Models\ProjectTower;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectClass {


    public function __construct()
    {
    }

    public function getDefaultCompanyProjects ( $request, $onlyAssignedTo = false) {

        $lists = Project::query()->with(['company','companyBranch', 'assignToUser','updatedUser']);
        if( $onlyAssignedTo ){
            $lists->createdByOrAssignToAuth();
        }
        $lists = $lists->customFilter( $request->input('filter') )
                        ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                        ->paginate( $request->input('per_page', config('app.per_page') ) );

        return $lists;
    }


    public function create ( User $user, $request ) {

        $project = new Project();
        $project->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $project->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $project->created_by = $user->id;
        $project = $this->createOrUpdate( $project, $user, $request );


        return $project;
    }

    public function update ( User $user, Project $project, $request ){
        return $this->createOrUpdate( $project, $user, $request );
    }

    public function createOrUpdate( Project $project, User $user, $request ){

        $project->company_branch_id = $request->input('company_branch');
        $project->assign_to = $request->input('assign_to');

        $project->title = $request->input('title');
        $project->rera_reg_no = $request->input('rera_reg_no');
        $project->project_no = $request->input('project_no');
        $project->launch_date = $request->input('launch_date');
        $project->completion_date = $request->input('completion_date');
        $project->company_branch_id = $request->input('company_branch');
        $project->project_area = $request->input('project_area');
        $project->developer_name = $request->input('developer_name');
        $project->approved_by = $request->input('approved_by');
        $project->open_space = $request->input('open_space');
        $project->total_unit = $request->input('total_unit');
        $project->availability = $request->input('availability');
        $project->availability_date = $request->input('availability_date');
        $project->commencement_certificate = $request->input('commencement_certificate');
        $project->occupancy_certificate = $request->input('occupancy_certificate');
        $project->specification = $request->input('specification');
        $project->description = $request->input('description');
        $project->remark = $request->input('remark');
        $project->landmark = $request->input('landmark');
        $project->city = $request->input('city');
        $project->locality = $request->input('locality');
        $project->building = $request->input('building');
        $project->address = $request->input('address');
        $project->amenities = $request->input('amenities');
        $project->owner_name = $request->input('owner_name');
        $project->owner_email = $request->input('owner_email');
        $project->owner_phone = $request->input('owner_phone');
        $project->assign_to = $request->input('assign_to');
        $project->walkthrough_link = $request->input('walk_through_link');
        $project->virtual_tour = $request->input('virtual_tour');

        $project->updated_by = $user->id;

        if( $project->isDirty( 'assign_to' ) ){
            $project->assign_date = today();
        }

        $project->save();

        $this->manageProjectTowers( $project, $request->input('project_towers') );

        $this->manageProjectPlans( $project, $request->input('project_plans') );

        $this->manageProjectCharges( $project, $request->input('project_charges') );

        $images = $request->input('images');

        if( !empty( $images ) && is_array( $images )){
            $mediaId = Arr::pluck( Arr::flatten($request->images,1), 'id');

            $removedMedia = $project->media()->whereNotIn( 'id', $mediaId )->whereNotIn('collection_name',['documents'])->get();
            if( $removedMedia->count() ){
                foreach( $removedMedia as $item ){
                    $project->deleteMedia( $item );
                }
            }
            foreach( $images as $imgType => $files ){
                if( !empty( $files ) ){
                    foreach( $files as $fileName ){
                        $tmpFileNm = data_get( $fileName, 'id');
                        if( !empty( $tmpFileNm ) ){

                            $tmpFile = 'tmp_media/' . $tmpFileNm;
                            if( Storage::disk('public')->has( $tmpFile ) ){
                                $project->addMediaFromDisk( $tmpFile, 'public')->toMediaCollection( $imgType );
                            }
                        }
                    }
                }
            }
        }else{
            $project->clearMediaCollectionExcept('documents');
        }

        $documents = $request->input('documents');

        if( !empty( $documents ) && is_array($documents)){
            $documentsId = Arr::pluck( $documents, 'id');

            $removeDocuments = $project->media()
                                    ->where('collection_name','documents')
                                    ->whereNotIn( 'id', $documentsId )
                                    ->get();

            if( $removeDocuments->count() ){
                foreach( $removeDocuments as $item ){
                    $project->deleteMedia( $item );
                }
            }

            foreach( $documents as $fileName ){
                $tmpFileNm = data_get( $fileName, 'id');
                if( !empty( $tmpFileNm ) ){

                    $tmpFile = 'tmp_media/' . $tmpFileNm;
                    if( Storage::disk('public')->has( $tmpFile ) ){
                        $project->addMediaFromDisk( $tmpFile, 'public')->toMediaCollection( 'documents' );
                    }
                }
            }
        }else{
            $project->clearMediaCollection('documents');
        }
        if( !$project->wasRecentlyCreated ){
            $project->refresh();

        }

        return $project;
    }


    private function manageProjectTowers ( $project, $towersData ) {
        if( !empty( $towersData ) ){
            $allIds = Arr::pluck( $towersData, 'id');
            $project->projectTowers()->whereNotIn('id', $allIds )->delete();
            foreach( $towersData as $item  ){
                $filterData = array_filter( $item );
                if( !empty( $filterData ) ){
                    $obj = $project->projectTowers()->find( data_get( $item, 'id') );
                    if( is_null( $obj ) ){
                        $obj = new ProjectTower();
                        $obj->user_id = $project->user_id;
                        $obj->company_id = $project->company_id;
                        $obj->created_by = $project->created_by;
                        $obj->project_id = $project->id;
                    }
                    $obj->updated_by = $project->updated_by;
                    $obj->tower_name = data_get( $item, 'tower_name');
                    $obj->completion_date = data_get( $item, 'completion_date');
                    $obj->save();

                }
            }
        }else{
            $project->projectTowers()->delete();
        }
    }

    private function manageProjectPlans ( $project, $plansData ) {
        if( !empty( $plansData ) ){
            $allIds = Arr::pluck( $plansData, 'id');
            $project->projectPlans()->whereNotIn('id', $allIds )->delete();
            foreach( $plansData as $item  ){
                $filterData = array_filter( $item );
                if( !empty( $filterData ) ){
                    $obj = $project->projectPlans()->find( data_get( $item, 'id') );
                    if( is_null( $obj ) ){
                        $obj = new ProjectPlan();
                        $obj->user_id = $project->user_id;
                        $obj->company_id = $project->company_id;
                        $obj->created_by = $project->created_by;
                        $obj->project_id = $project->id;
                    }
                    $obj->updated_by = $project->updated_by;
                    $obj->tower = data_get( $item, 'tower');
                    $obj->type = data_get( $item, 'type');
                    $obj->bhk = data_get( $item, 'bhk');
                    $obj->area = data_get( $item, 'area');
                    $obj->price = data_get( $item, 'price');
                    $obj->basic_price = data_get( $item, 'basic_price');
                    $obj->save();

                }
            }
        }else{
            $project->projectPlans()->delete();
        }
    }

    private function manageProjectCharges ( $project, $chargessData ) {
        if( !empty( $chargessData ) ){
            $allIds = Arr::pluck( $chargessData, 'id');
            $project->projectCharges()->whereNotIn('id', $allIds )->delete();
            foreach( $chargessData as $item  ){
                $filterData = array_filter( $item );
                if( !empty( $filterData ) ){
                    $obj = $project->projectCharges()->find( data_get( $item, 'id') );
                    if( is_null( $obj ) ){
                        $obj = new ProjectCharge();
                        $obj->user_id = $project->user_id;
                        $obj->company_id = $project->company_id;
                        $obj->created_by = $project->created_by;
                        $obj->project_id = $project->id;
                    }
                    $obj->updated_by = $project->updated_by;
                    $obj->charges = data_get( $item, 'charges');
                    $obj->description = data_get( $item, 'description');
                    $obj->price = data_get( $item, 'price');
                    $obj->escalation_from = data_get( $item, 'escalation_from');
                    $obj->save();

                }
            }
        }else{
            $project->projectCharges()->delete();
        }
    }
}
