<?php

namespace App\Services\Database;

use App\Models\SiteVisit;
use App\Models\User;

class SiteVisitClass {

    public function __construct()
    {
    }

    public function getDefaultCompanySiteVisits ( $request, $onlyAssignedTo = false, $onlyCreatedBy = false ) {

        $lists = SiteVisit::query()
                        ->withCount('leads')
                        ->with([
                            'company',
                            'companyBranch',
                            'property',
                            'project',
                            'assignToUser',
                            'sourceManagerUser',
                            'closingManagerUser'
                        ]);

        if( $onlyAssignedTo ){
            $lists->createdByOrAssignedToAuth();
        }else if( $onlyCreatedBy ){
            $lists->createdByAuth();
        }

        $lists = $lists->customFilter( $request->input('filter') )
                    ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                    ->paginate( $request->input('per_page', config('app.per_page') ) );

        return $lists;
    }


    public function create ( User $user, $request ) {

        $siteVisit = new SiteVisit();
        $siteVisit->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $siteVisit->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $siteVisit->created_by = $user->id;
        $siteVisit = $this->createOrUpdate( $siteVisit, $user, $request );


        return $siteVisit;
    }

    public function update ( User $user, SiteVisit $siteVisit, $request ){
        return $this->createOrUpdate( $siteVisit, $user, $request );
    }

    public function createOrUpdate( SiteVisit $siteVisit, User $user, $request ){

        $siteVisit->company_branch_id = $request->input('company_branch');
        $siteVisit->type = $request->input('type');
        $siteVisit->property_id = $request->input('property_id');
        $siteVisit->project_id = $request->input('project_id');
        $siteVisit->site_name = $request->input('site_name');
        $siteVisit->site_owner = $request->input('site_owner');
        $siteVisit->visit_type = $request->input('visit_type');
        $siteVisit->time_in = $request->input('time_in');
        $siteVisit->time_out = $request->input('time_out');
        $siteVisit->comments = $request->input('comments');
        $siteVisit->location = $request->input('location');
        $siteVisit->latitude = $request->input('latitude');
        $siteVisit->longitude = $request->input('longitude');
        $siteVisit->source_manager = $request->input('source_manager');
        $siteVisit->closing_manager = $request->input('closing_manager');
        $siteVisit->assign_to = $request->input('assign_to');
        $siteVisit->updated_by = $user->id;
        $siteVisit->save();

        if( $request->filled('leads') ){

            $siteVisit->leads()->sync( $request->input( 'leads', [] ) );
        }else{
            $siteVisit->leads()->detach();

        }

        if( !$siteVisit->wasRecentlyCreated ){
            $siteVisit->refresh();
        }

        return $siteVisit;
    }

}
