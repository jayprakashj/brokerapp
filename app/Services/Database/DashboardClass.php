<?php

namespace App\Services\Database;

use App\Http\Resources\Api\Dashboard\LeadListResource;
use App\Http\Resources\Api\Dashboard\LeadSourceWithCountResource;
use App\Http\Resources\Api\Dashboard\UsersWithLeadCountResource;
use App\Models\CompanyBranch;
use App\Models\CompanyMember;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertySubTypeList;
use App\Models\PropertyTransactionList;
use App\Models\PropertyTypeList;
use App\Models\SiteVisit;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardClass {


    public function dashboardData ( $user, $request ) {
        $selectedDate = $request->input('date', today()->format('Y-m-d') );

        if( $user->isCompanyAdmin() || $user->can('Member List') ){

            $usersWiseLeadsCount = $this->fetchUsersWiseLeadsCount( $user, $selectedDate );
        }else{
            $usersWiseLeadsCount = collect();

        }

        $data = [
            'property_count' => $this->fetchPropertyCount( $user, $selectedDate ),
            'project_count' => $this->fetchProjectCount( $user, $selectedDate ),
            'member_count' => $this->fetchMemberCount( $user ),
            'branch_count' => $this->fetchBranchCount( $user ),
            'contact_count' => $this->fetchContactCount( $user, $selectedDate ),
            'lead_count' => $this->fetchLeadsCount( $user, $selectedDate ),
            'oppertunity_count' => $this->fetchOppertunityCount( $user, $selectedDate ),
            'visited_count' => $this->fetchSiteVisitsCount( $user, $selectedDate ),
            'won_count' => $this->fetchWonLeadsCount( $user, $selectedDate ),
            'month_leads' => $this->fetchThisMonthLead( $user ),
            'month_site_visits' => $this->fetchMonthlySiteVisits( $user ),
            'today_leads' => LeadListResource::collection( $this->fetchTodayLeads( $user ) ),
            'today_followup_leads' => LeadListResource::collection( $this->fetchTodayFollowupLeads( $user ) ),
            'lead_sources_with_count' => LeadSourceWithCountResource::collection( $this->fetchLeadSourceWithCount( $user, $selectedDate ) ),
            'users_with_lead_count' => UsersWithLeadCountResource::collection( $usersWiseLeadsCount ),
            'property_type_wise_count' => $this->fetchProperyCountWithPropertyTypeTransaction( $user, $selectedDate ),
        ];

        return $data;
    }

    private function fetchPropertyCount ($user, $selectedDate) {
        $propertyCount = Property::query()->filterDate( 'created_at', $selectedDate, '>=' );

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Property List') ){
            $propertyCount->createdByOrAssignToAuth();
        }
        $propertyCount = $propertyCount->count();

        return $propertyCount;
    }

    private function fetchProjectCount ($user, $selectedDate) {
        $projectCount = Project::query()->filterDate( 'created_at', $selectedDate, '>=' );

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Project List') ){
            $projectCount->createdByOrAssignToAuth();
        }
        $projectCount = $projectCount->count();

        return $projectCount;
    }

    private function fetchLeadsCount ($user, $selectedDate) {
        $leadCount = Lead::query()->filterDate( 'created_at', $selectedDate, '>=' );

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $leadCount->createdByOrAssignToAuth();
        }
        $leadCount = $leadCount->count();

        return $leadCount;
    }

    private function fetchOppertunityCount ($user, $selectedDate) {
        $leadCount = Lead::query()
                        ->whereHas('oppertunityComment', function( $q ) use( $selectedDate ) {
                            $q->filterDate('created_at', $selectedDate, '>=');
                        });

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $leadCount->createdByOrAssignToAuth();
        }
        $leadCount = $leadCount->count();

        return $leadCount;
    }

    private function fetchWonLeadsCount ($user, $selectedDate) {
        $leadCount = Lead::query()
                        ->whereHas('wonComment', function( $q ) use( $selectedDate ) {
                            $q->filterDate('created_at', $selectedDate, '>=');
                        });

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $leadCount->createdByOrAssignToAuth();
        }
        $leadCount = $leadCount->count();

        return $leadCount;
    }

    private function fetchVisitedLeadsCount ($user, $selectedDate) {
        $visitedCount = Lead::query()
                        ->propertProjectSiteVisitExists( $selectedDate )
                        ->filterDate( 'created_at', $selectedDate, '>=' );

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $visitedCount->createdByOrAssignToAuth();
        }
        $visitedCount = $visitedCount->count();

        return $visitedCount;
    }

    private function fetchSiteVisitsCount ($user, $selectedDate) {
        $siteVisitCount = SiteVisit::query()
                        ->filterDate( 'created_at', $selectedDate, '>=' );

        if( !$user->isCompanyAdmin() ){
            $siteVisitCount->createdByOrAssignToAuth();
        }
        $siteVisitCount = $siteVisitCount->count();

        return $siteVisitCount;
    }

    private function fetchMemberCount ( $user ) {
        $memberCount = 0;
        if( $user->can('Member List') ){
            $memberCount = CompanyMember::count();
        }
        return $memberCount;
    }

    private function fetchBranchCount ( $user ) {
        $branchCount = 0;
        if( $user->can('Branch List') ){
            $branchCount = CompanyBranch::count();
        }

        return $branchCount;
    }

    private function fetchContactCount ( $user, $selectedDate ) {
        $contactCount = 0;

        if( $user->can('Contact List') ){
            $contactCount = Contact::filterDate( 'created_at', $selectedDate, '>=' )->count();
        }

        return $contactCount;
    }

    private function fetchThisMonthLead ( $user ) {
        $monthLeads = Lead::query()->whereMonth('updated_at', date('m'));
        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $monthLeads->createdByOrAssignedToAuth();
        }
        $monthLeads = $monthLeads->count();
        return $monthLeads;
    }

    private function fetchTodayLeads ( $user ) {
        $todaysLeads = Lead::with('lastComment')
                            ->whereRelation('newLeadComment', DB::raw('DATE(updated_at)'), '=', today());

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $todaysLeads->createdByOrAssignedToAuth();

        }
        $todaysLeads = $todaysLeads->latest()->get();
        return $todaysLeads;
    }

    private function fetchTodayFollowupLeads ( $user ) {
        $todaysFollowupLeads = Lead::with('lastComment')
                                    ->whereDate('followup_date', '<=',  today())
                                    ->whereNotNull('followup_date')
                                    ->where('lead_status', 'In Progress');
        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $todaysFollowupLeads->createdByOrAssignedToAuth();

        }
        $todaysFollowupLeads = $todaysFollowupLeads->orderBy('followup_date')->get();
        return $todaysFollowupLeads;
    }

    private function fetchMonthlySiteVisits ( $user ) {
        $monthSiteVisits = SiteVisit::query()->whereMonth('created_at', date('m'));

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Site Visit List') ){
            $monthSiteVisits->createdByOrAssignedToAuth();
        }
        $monthSiteVisits = $monthSiteVisits->count();

        return $monthSiteVisits;
    }

    private function fetchLeadSourceWithCount ( $user, $selectedDate ){
        $commonWhereClause = function ( $q ) use( $selectedDate, $user ){
            $q->filterDate( 'created_at', $selectedDate, '>=' );
            if( !$user->isCompanyAdmin() ){
                $q->createdByOrAssignedToAuth();
            }
        };
        $leadSources = LeadSource::withCount([
                                'leads' => $commonWhereClause,
                                'leads as won_leads' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereHas('wonComment', function( $q ) use( $selectedDate ) {
                                            $q->filterDate('created_at', $selectedDate, '>=');
                                        });
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                },
                                'leads as oppertunities' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereHas('oppertunityComment', function( $q ) use( $selectedDate ) {
                                            $q->filterDate('created_at', $selectedDate, '>=');
                                        });
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                },
                                'leads as visited' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereRelation( 'siteVisits', DB::Raw('DATE(site_visits.created_at)'), '>=', $selectedDate );
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                }
                            ])->get();

        return $leadSources;

    }

    private function fetchUsersWiseLeadsCount ( $user, $selectedDate ){
        $users = User::withCount([
                                'leads as qualified' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereHas('qualifiedComment', function( $q ) use( $selectedDate ) {
                                            $q->filterDate('created_at', $selectedDate, '>=');
                                        });
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                },
                                'leads as won_leads' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereHas('wonComment', function( $q ) use( $selectedDate ) {
                                            $q->filterDate('created_at', $selectedDate, '>=');
                                        });
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                },
                                'leads as oppertunities' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereHas('oppertunityComment', function( $q ) use( $selectedDate ) {
                                            $q->filterDate('created_at', $selectedDate, '>=');
                                        });
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                },
                                'leads as visited' => function( $q ) use ( $selectedDate, $user ) {
                                    $q->whereRelation( 'siteVisits', DB::Raw('DATE(site_visits.created_at)'), '>=', $selectedDate );
                                    if( !$user->isCompanyAdmin() ){
                                        $q->createdByOrAssignedToAuth();
                                    }
                                }
                            ])->get();

        return $users;

    }

    private function fetchProperyCountWithPropertyTypeTransaction ( $user, $selectedDate ) {
        $propertyTransactionTblName = (new PropertyTransactionList())->getTable();
        $propertyTypeTblName = (new PropertyTypeList())->getTable();

        $propertySubtypeListQry = PropertySubTypeList::select('name')
                                        ->where('property_type_id', '=', DB::raw( $propertyTypeTblName.'.id'))
                                        ->toRawSql();

        $properties = Property::selectRaw('count(id)')
                        ->where('property_transaction', '=', DB::raw( $propertyTransactionTblName . '.name'))
                        ->whereRaw('property_type in ( '.$propertySubtypeListQry . ')' )
                        ->whereRaw('DATE(created_at) >= '.$selectedDate );

        if( !$user->isCompanyAdmin() ){
            $properties->createdByOrAssignToAuth();
        }

        $availableProperties = (clone $properties)->where('availability', 'Yes');

        $properties = DB::table(
                            DB::raw( '' . $propertyTransactionTblName . ', ' . $propertyTypeTblName )
                        )
                        ->select(
                            DB::raw('CONCAT('.$propertyTransactionTblName.'.name, " Properties") AS property_transaction_name'),
                            $propertyTransactionTblName.'.name AS property_transaction',
                            $propertyTypeTblName.'.name AS property_type_name',
                            DB::raw('( ' . $properties->toRawSql() . ') as properties_count'),
                            DB::raw('( ' . $availableProperties->toRawSql() . ') as availble_properties_count')
                        )
                        ->get()
                        ->groupBy('property_transaction_name');

        $projectsSubQry = Project::selectRaw(
                                'count(id)'
                            )
                            ->filterDate('created_at', $selectedDate, '>=')
                            ->where('project_type', DB::raw('projects.project_type') );

        $availableProjectsQry = (clone $projectsSubQry )->where('availability', 'Yes')->toRawSql();

        $projectsSubQry = $projectsSubQry->toRawSql();

        $projects = Project::select(
                    'project_type AS property_type_name',
                    DB::raw( '( ' . $projectsSubQry . ' ) as properties_count'),
                    DB::raw( '( ' . $availableProjectsQry . ' ) as availble_properties_count')
                )
                ->whereNotNull('project_type')
                ->groupBy('project_type')
                ->get();

        $res = [];

        foreach( $properties->keys() as $key ){
            $res[] = [
                'name' => $key,
                'items' => $properties->get($key)
            ];
        }

        $res[] = [
            'name' => 'New Projects',
            'items' => $projects
        ];

        return $res;
    }
}
