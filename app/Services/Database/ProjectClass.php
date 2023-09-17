<?php

namespace App\Services\Database;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectClass {


    public function __construct()
    {
    }

    public function getDefaultCompanyProjects ( $perPage = 24, $onlyAssignedTo = false) {

        $lists = Project::query()->with(['company','companyBranch']);
        if( $onlyAssignedTo ){
            $lists->createdByOrAssignToAuth();
        }
        $lists = $lists->paginate( $perPage );

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

        $project->name = $request->input('name');

        $project->company_branch_id = $request->input('company_branch');
        $project->assign_to = $request->input('assign_to');

        $project->building_name = $request->input('building_name');
        $project->unit_no = $request->input('unit_no');

        $project->updated_by = $user->id;

        if( $project->isDirty( 'assign_to' ) ){
            $project->assign_date = today();
        }

        $project->save();

        $images = $request->input('images');

        if( !empty( $images ) && is_array( $images )){
            $mediaId = Arr::pluck( Arr::flatten($request->images,1), 'id');

            $removedMedia = $project->media()->whereNotIn( 'id', $mediaId )->get();
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
            $project->clearMediaCollection();
        }

        if( !$project->wasRecentlyCreated ){
            $project->refresh();

        }

        return $project;
    }


}
