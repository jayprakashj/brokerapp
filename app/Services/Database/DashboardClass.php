<?php

namespace App\Services\Database;

use App\Http\Resources\Api\Dashboard\LeadListResource;
use App\Models\CompanyBranch;
use App\Models\CompanyMember;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Property;
use App\Models\SiteVisit;

class DashboardClass {


    public function dashboardData ( $user ) {
        $memberCount = 0;
        $branchCount = 0;
        $contactCount = 0;

        $propertyCount = Property::query();
        $projectCount = Project::query();
        $monthLeads = Lead::query()->whereMonth('updated_at', date('m'));
        $monthSiteVisits = SiteVisit::query()->whereMonth('created_at', date('m'));
        $todaysLeads = Lead::with('lastComment')->whereDate('updated_at', today());

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Property List') ){
            $propertyCount->createdByOrAssignToAuth();
        }
        $propertyCount = $propertyCount->count();

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Project List') ){
            $projectCount->createdByOrAssignToAuth();
        }
        $projectCount = $projectCount->count();

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Lead List') ){
            $monthLeads->createdByOrAssignedToAuth();
            $todaysLeads->createdByOrAssignedToAuth();

        }
        $monthLeads = $monthLeads->count();
        $todaysLeads = $todaysLeads->get();

        if( !$user->isCompanyAdmin() && $user->can('Only Assigned Site Visit List') ){
            $monthSiteVisits->createdByOrAssignedToAuth();
        }
        $monthSiteVisits = $monthSiteVisits->count();

        if( $user->can('Member List') ){
            $memberCount = CompanyMember::count();
        }

        if( $user->can('Member List') ){
            $memberCount = CompanyMember::count();
        }

        if( $user->can('Branch List') ){
            $branchCount = CompanyBranch::count();
        }

        if( $user->can('Contact List') ){
            $contactCount = Contact::count();
        }

        $data = [
            'property_count' => $propertyCount,
            'project_count' => $projectCount,
            'member_count' => $memberCount,
            'branch_count' => $branchCount,
            'contact_count' => $contactCount,
            'month_leads' => $monthLeads,
            'month_site_visits' => $monthSiteVisits,
            'today_leads' => LeadListResource::collection( $todaysLeads )
        ];
        return $data;
    }

}
