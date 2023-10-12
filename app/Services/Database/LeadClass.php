<?php

namespace App\Services\Database;

use App\Events\NewLeadEvent;
use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class LeadClass {

    private $contactClass;
    private $leadCommentClass;

    public function __construct()
    {
        $this->contactClass = new ContactClass;
        $this->leadCommentClass = new LeadCommentClass;
    }

    public function getDefaultCompanyLeads ( $request, $onlyAssignedTo = false, $onlyCreatedBy = false ) {

        $lists = Lead::query()->with(['companyBranch', 'properties', 'projects', 'assignToUser', 'updatedUser']);

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


    public function storeEnquiryForm ( $request ) {

        $company = Company::first();
        $contact =  $this->findOrCreateContact( $company->owner, $request );
        $lead = Lead::where('contact_id', $contact->id)->first();
        if( is_null( $lead ) ){
            $lead = new Lead();
        }
        $lead->company_id = $company->id ?? null;
        $lead->company_branch_id = CompanyBranch::first()->id;

        $lead->user_id = $company->owned_by;
        $lead->created_by = $company->owned_by;
        $lead->updated_by = $company->owned_by;

        $lead->contact_id = $contact->id;

        $lead->is_enquiry = 1;
        $lead->enquiry_type = Lead::ENQUIRY_TYPES[ $request->enquiry_type ];

        $lead->title = 'Enquiry / '. $lead->enquiry_type;
        $lead->customer_name = $request->input('name');
        $lead->customer_mobile = $request->input('mobile');
        $lead->customer_email = $request->input('email');
        $lead->customer_city = $request->input('city');
        $lead->remark = $request->input('remark');
        $lead->interest_in = $request->input('interest_in');
        $lead->min_budget = $request->input('min_budget');
        $lead->max_budget = $request->input('max_budget');
        $lead->property_type = $request->input('property_type');

        $lead->lead_source = Lead::DEFAULT_LEAD_SOURCE;
        $lead->lead_status = Lead::DEFAULT_LEAD_STATUS;

        $lead->save();

        if( !$lead->wasRecentlyCreated ){
            $this->leadCommentClass->createWithLeadUpdate( $lead, $company->owner );
            $lead->refresh();

        }else{
            $this->leadCommentClass->create( $lead, $request, $company->owner );

        }

        return $lead;
    }

    public function create ( User $user, $request ) {

        $lead = new Lead();
        $lead->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $lead->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $lead->created_by = $user->id;
        $lead = $this->createOrUpdate( $lead, $user, $request );


        return $lead;
    }

    public function update ( User $user, Lead $lead, $request ){
        return $this->createOrUpdate( $lead, $user, $request );
    }

    public function findOrCreateContact ( $user, $request ){
        $contact = $this->contactClass->findByMobile( $request->input('mobile') );
        if( is_null( $contact ) && $request->filled( 'email' ) ){
            $contact = $this->contactClass->findByEmail( $request->input('email') );
        }
        if( is_null( $contact ) ){
            $customerRequest = Request::createFrom( $request );
            $customerRequest->merge([
                'email' =>  $request->input('email'),
                'mobile' =>  $request->input('mobile'),
                'city' =>  $request->input('city'),
            ]);
            $contact = $this->contactClass->create( $user, $customerRequest );
        }
        return $contact;
    }

    public function createOrUpdate( Lead $lead, User $user, $request ){

        $lead->title = $request->input('title');
        $lead->contact_id = $this->findOrCreateContact( $user, $request )->id;
        $lead->company_branch_id = $request->input('company_branch');
        $lead->customer_name = $request->input('name');
        $lead->customer_mobile = $request->input('mobile');
        $lead->customer_email = $request->input('email');
        $lead->customer_city = $request->input('city');
        $lead->remark = $request->input('remark');
        $lead->keywords = $request->input('keywords');
        $lead->interest_in = $request->input('interest_in');
        $lead->purpose = $request->input('purpose');
        $lead->min_budget = $request->input('min_budget');
        $lead->max_budget = $request->input('max_budget');
        $lead->assigned_to = $request->input('assigned_to');
        $lead->is_confidential = $request->filled('is_confidential') && $request->is_confidential ? Lead::CONFIDENTIAL_YES : Lead::CONFIDENTIAL_NO;
        $lead->is_private = $request->filled('is_private') && $request->is_private ? Lead::IS_PRIVATE_YES : Lead::IS_PRIVATE_NO;
        $lead->is_protected = $request->filled('is_protected') && $request->is_protected ? Lead::IS_PROTECTED_YES : Lead::IS_PROTECTED_NO;
        $lead->updated_by = $user->id;
        $lead->lead_source = LeadSource::whereName( $request->input('lead_source') )->first()->name;
        $lead->lead_status = LeadStatus::whereName( $request->input('lead_status') )->first()->name;
        $lead->followup_date = $request->input('followup_date');
        $lead->property_type = $request->input('property_type');
        $lead->enquiry_type = $request->enquiry_type;

        if( $lead->isDirty( 'assigned_to' ) ){
            $lead->assigned_date = today();
        }
        $lead->save();

        if( $request->filled('property') ){

            $lead->properties()->sync( $request->input( 'property', [] ) );
        }else{
            $lead->properties()->detah();

        }

        if( $request->filled('project') ){

            $lead->projects()->sync( $request->input( 'project', [] ) );
        }else{
            $lead->projects()->detah();

        }

        if( !$lead->wasRecentlyCreated ){
            $this->leadCommentClass->createWithLeadUpdate( $lead, $user );
            $lead->refresh();

        }else{
            $this->leadCommentClass->create( $lead, $request, $user );

        }

        NewLeadEvent::dispatch( $lead );

        return $lead;
    }


    public function updateLeadFollowup ( Lead $lead, User $user, $request ){

        $lead->followup_date = $request->input('followup_date');
        $lead->lead_status = LeadStatus::whereName( $request->input('lead_status') )->first()->name;
        $lead->updated_by = $user->id;
        $lead->save();

        $this->leadCommentClass->create( $lead, $request, $user );
    }
}
