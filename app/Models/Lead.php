<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, CommonFilter;

    const DEFAULT_LEAD_STATUS = 'Open';
    const DEFAULT_LEAD_SOURCE = 'Own Website';

    const CONFIDENTIAL_YES = 1;
    const CONFIDENTIAL_NO = 0;

    const CONFIDENTIALS = [
        self::CONFIDENTIAL_YES => 'Yes',
        self::CONFIDENTIAL_NO => 'No',
    ];

    const IS_PRIVATE_YES = 1;
    const IS_PRIVATE_NO = 0;

    const IS_PRIVATE_LIST = [
        self::IS_PRIVATE_YES => 'Yes',
        self::IS_PRIVATE_NO => 'No',
    ];

    const IS_PROTECTED_YES = 1;
    const IS_PROTECTED_NO = 0;

    const IS_PROTECTED_LIST = [
        self::IS_PROTECTED_YES => 'Yes',
        self::IS_PROTECTED_NO => 'No',
    ];

    const ENQUIRY_TYPES = [
        'buy' => 'Buy',
        'sell' => 'Sell',
        'rent_tenant' => 'Rent ( Tenant )',
        'rent_owner' => 'Rent ( Owner )',
    ];

    protected $casts = [
        'property_type' => 'array',
    ];


    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function contact () {
        return $this->belongsTo( Contact::class, 'contact_id', 'id');
    }


    public function assignToUser (){
        return $this->belongsTo( User::class, 'assigned_to', 'id');
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function properties (){
        return $this->belongsToMany( Property::class, 'lead_property_pivot', 'lead_id', 'property_id');
    }

    public function projects (){
        return $this->belongsToMany( Project::class, 'lead_project_pivot', 'lead_id', 'project_id');
    }

    public function siteVisits (){
        return $this->belongsToMany( SiteVisit::class, 'lead_site_visit_pivot', 'lead_id', 'site_visit_id' );
    }

    public function latestSiteVisits (){
        return $this->siteVisits()->latest();
    }

    public function comments (){
        return $this->hasMany( LeadComment::class, 'lead_id', 'id');
    }

    public function latestComments (){
        return $this->comments()->latest();
    }

    public function wonComment (){
        return $this->comments()->wonLeadStatus();
    }

    public function oppertunityComment (){
        return $this->comments()->oppertunitiesLeadStatus();
    }

    public function qualifiedComment (){
        return $this->comments()->qualifiedLeadStatus();
    }

    public function newLeadComment (){
        return $this->comments()->newLeadStatus();
    }

    public function lastComment (){
        return $this->hasOne( LeadComment::class, 'lead_id', 'id')->latest();
    }

    public function scopeAssignedToAuth ( $q, $boolean = 'and' ){
        return $q->where('assigned_to', '=', auth()->id(), $boolean );
    }

    public function scopeCreatedByAuth ( $q, $boolean = 'and' ){
        return $q->where('created_by','=', auth()->id(), $boolean );
    }

    public function scopeCreatedByOrAssignedToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignedToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function scopePropertProjectSiteVisitExists ( $q, $selectedDate, $dateColumn = 'created_at', $operator = '>='  ){
        return $q->where( function( $whereClause ) use( $dateColumn, $selectedDate, $operator ) {

                $whereClause->orWhereHas('properties', function( $q ) use( $dateColumn, $selectedDate, $operator ) {
                                $q->whereHas('siteVisits', function( $q ) use( $dateColumn, $selectedDate, $operator ) {
                                    $q->filterDate($dateColumn, $selectedDate, $operator);
                                });
                            })
                            ->orWhereHas('projects', function( $q ) use( $dateColumn, $selectedDate, $operator ) {
                                $q->whereHas('siteVisits', function( $q ) use( $dateColumn, $selectedDate, $operator ) {
                                    $q->filterDate($dateColumn, $selectedDate, $operator);
                                });
                            });
            });
    }
    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'title':
                    $q->orderBy( 'title', $sortOrder);
                    break;
                case 'customer_name':
                    $q->orderBy( 'customer_name', $sortOrder);
                    break;
                case 'company_branch':
                    $q->orderBy( CompanyBranch::select('name')->whereColumn('id', 'leads.company_branch_id')->limit(1) , $sortOrder);
                    break;
                case 'assign_to':
                    $q->orderBy( User::select('name')->whereColumn('id', 'leads.assigned_to')->limit(1) , $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'leads.updated_by')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'city':
                    $q->orderBy( 'customer_city' , $sortOrder);
                    break;
                case 'mobile':
                    $q->orderBy( 'customer_mobile' , $sortOrder);
                    break;
                case 'email':
                    $q->orderBy( 'customer_email' , $sortOrder);
                    break;
                case 'lead_source':
                    $q->orderBy( 'lead_source' , $sortOrder);
                    break;
                case 'lead_status':
                    $q->orderBy( 'lead_status' , $sortOrder);
                    break;
                case 'site_visits_count':
                    $q->orderBy( 'site_visits_count' , $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeFilterTitleLike ( $q, $value, $boolean = 'and' ){
        return $q->where('title', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterCustomerNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('customer_name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterTitleCustomerNameLike ( $q, $value, $boolean = 'and' ){
        return $q->{$boolean == 'and' ? 'where' : 'orWhere'}(function( $whereQry ) use ( $value ) {
                $whereQry->orWhere('title', 'LIKE', '%'. $value . '%');
                $whereQry->orWhere('customer_name', 'LIKE', '%'. $value . '%');
            });
    }

    public function scopeFilterMobileLike ( $q, $value, $boolean = 'and' ){
        return $q->where('customer_mobile', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterEmailLike ( $q, $value, $boolean = 'and' ){
        return $q->where('customer_email', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterCityLike ( $q, $value, $boolean = 'and' ){
        return $q->where('customer_city', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterLeadSource ( $q, $value, $boolean = 'and' ){
        return $q->where('lead_source', '=', $value, $boolean);
    }

    public function scopeFilterLeadStatus ( $q, $value, $boolean = 'and' ){
        return $q->where('lead_status', '=', $value, $boolean);
    }

    public function scopeFilterEnquiryType ( $q, $value, $boolean = 'and' ){
        return $q->where('enquiry_type', '=', $value, $boolean);
    }

    public function scopeWorkingLead ( $q,){
        return $q->whereNotIn('lead_status', ['Won', 'Disqualified']);
    }

    public function scopeFilterProjects ( $q, $value, $boolean = 'and' ){
        if( !empty( $value ) ) {
            if( is_array( $value ) ){
                return $q->{$boolean == 'and' ? 'whereHas' : 'orWhereHas'}('projects', function( $subQry ) use ( $value ){
                    $subQry->whereIn('project_id', $value);
                });
            }else{
                $q->{$boolean == 'and' ? 'whereRelation' : 'orWhereRelation'}('project_id', 'id', '=', $value);
            }
        }
        return $q;
    }

    public function scopeFilterProperties ( $q, $value, $boolean = 'and' ){
        if( !empty( $value ) ) {
            if( is_array( $value ) ){
                return $q->{$boolean == 'and' ? 'whereHas' : 'orWhereHas'}('properties', function( $subQry ) use ( $value ){
                    $subQry->whereIn('property_id', $value);
                });
            }else{
                $q->{$boolean == 'and' ? 'whereRelation' : 'orWhereRelation'}('properties', 'property_id', '=', $value);
            }
        }
        return $q;
    }

    public function scopeFilterAssignTo ( $q, $value, $boolean = 'and' ){
        return $q->where('assigned_to', '=', $value, $boolean);
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $title = data_get( $filter, 'title' );
            $enquiryType = data_get( $filter, 'enquiry_type' );
            $companyBranch = data_get( $filter, 'company_branch' );
            $customerName = data_get( $filter, 'customer_name' );
            $titleCustomerName = data_get( $filter, 'title_customer_name' );
            $mobile = data_get( $filter, 'mobile' );
            $email = data_get( $filter, 'email' );
            $city = data_get( $filter, 'city' );
            $properties = data_get( $filter, 'properties' );
            $projects = data_get( $filter, 'projects' );
            $leadSource = data_get( $filter, 'lead_source' );
            $leadStatus = data_get( $filter, 'lead_status' );
            $assignTo = data_get( $filter, 'assign_to' );
            $updatedAt = data_get( $filter, 'updated_at' );

            if( !empty( $title ) ){
                $q->filterTitleLike( $title );
            }
            if( !empty( $enquiryType ) ){
                $q->filterEnquiryType( $enquiryType );
            }
            if( !empty( $companyBranch ) ){
                $q->filterCompanyBranch( $companyBranch );
            }
            if( !empty( $customerName ) ){
                $q->filterCustomerNameLike( $customerName );
            }
            if( !empty( $titleCustomerName ) ){
                $q->filterTitleCustomerNameLike( $titleCustomerName );
            }
            if( !empty( $mobile ) ){
                $q->filterMobileLike( $mobile );
            }
            if( !empty( $email ) ){
                $q->filterEmailLike( $email );
            }
            if( !empty( $city ) ){
                $q->filterCityLike( $city );
            }
            if( !empty( $leadSource ) ){
                $q->filterLeadSource( $leadSource );
            }
            if( !empty( $leadStatus ) ){
                $q->filterLeadStatus( $leadStatus );
            }
            if( !empty( $projects ) ){
                $q->filterProjects( $projects );
            }
            if( !empty( $properties ) ){
                $q->filterProperties( $properties );
            }
            if( !is_null( $assignTo ) ){
                $q->filterAssignTo( $assignTo );
            }
            if( !is_null( $updatedAt ) ){
                $dt = explode(' to ', $updatedAt);
                $q->filterDate( 'updated_at',$dt );
            }
        }

        return $q;
    }

    public function isConfidential(){
        return $this->is_confidential == self::CONFIDENTIAL_YES;
    }

    public function isPrivate(){
        return $this->is_private == self::IS_PRIVATE_YES;
    }

    public function isProtected(){
        return $this->is_protected == self::IS_PROTECTED_YES;
    }

    public function isAssignedToMe(){
        return $this->assigned_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Lead List') && $this->isAssignedToMe()));
    }

    public function getPropertySuggestions(){
        if( in_array( $this->enquiry_type, [ 'Buy', 'Rent ( Tenant )' ])){
            $propertyTransaction = 'Rental';
            if( $this->enquiry_type == 'Buy'){
                $propertyTransaction = ['Sell', 'Resell'];

            }
            $filter = [
                'property_type' => $this->property_type,
                'city' => $this->customer_city,
                'price' => [
                    $this->min_budget,
                    $this->max_budget
                ]
            ];

            $orderByPropertyType = 'WHEN property_type IN ( "' . implode('", "',data_get( $filter, 'property_type', [] )) . '" ) THEN 1';
            $orderByCity = 'WHEN city LIKE "%' . data_get( $filter, 'city', null ) . '%" THEN 2';
            $properties = Property::where( function( $q ) use( $filter ){
                                    $q->filterPropertyType( data_get( $filter, 'property_type', [] ), 'or')
                                            ->filterCityLike( data_get( $filter, 'city', [] ), 'or');
                                } )
                                ->whereBetween('price', data_get( $filter, 'price', [] ))
                                ->filterPropertyTransaction( $propertyTransaction )
                                ->orderBy('price')
                                ->availabilityYes()
                                ->orderByRaw(
                                    'CASE ' .$orderByPropertyType. ' ' . $orderByCity . ' END'
                                )
                                ->latest()
                                ->limit( 20 )
                                ->get();
            return $properties;
        }
        return [];
    }

    public function getNameWithPrefix (){
        $name = $this->customer_name_prefix ?? '';
        if( !empty( $name ) ){
            $name .= ' ';
        }
        $name .= $this->customer_name;
        return $name;

    }

    public function getMobileWithCountryCode(){
        $mobile = array_filter( [ ($this->country_code ?? '91'), $this->customer_mobile ] );

        return '+'.implode('', $mobile);
    }
}
