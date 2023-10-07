<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteVisit extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, CommonFilter;

    CONST VISIT_TYPES = [
        [
            'id' => 'Direct Visit',
            'name' => 'Direct Visit'
        ],
        [
            'id' => 'Line Visit',
            'name' => 'Line Visit'
        ]
    ];

    const TYPES = [
        [
            'id' => 'property',
            'name' => 'Property'
        ],
        [
            'id' => 'project',
            'name' => 'Project'
        ]
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function property (){
        return $this->belongsTo( Property::class, 'property_id', 'id');
    }

    public function project (){
        return $this->belongsTo( Project::class, 'project_id', 'id');
    }

    public function sourceManagerUser (){
        return $this->belongsTo( User::class, 'source_manager', 'id');
    }

    public function closingManagerUser (){
        return $this->belongsTo( User::class, 'closing_manager', 'id');
    }

    public function assignToUser (){
        return $this->belongsTo( User::class, 'assign_to', 'id');
    }


    public function scopeAssignToAuth ( $q, $boolean = 'and' ){
        return $q->where('assign_to', '=', auth()->id(), $boolean );
    }

    public function scopeCreatedByAuth ( $q, $boolean = 'and' ){
        return $q->where('created_by','=', auth()->id(), $boolean );
    }

    public function scopeCreatedByOrAssignedToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function isAssignedToMe(){
        return $this->assign_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Site Visit List') && $this->isAssignedToMe()));
    }

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'site_name':
                    $q->orderBy( 'site_name', $sortOrder);
                    break;
                case 'company_branch':
                    $q->orderBy( CompanyBranch::select('name')->whereColumn('id', 'site_visits.company_branch_id')->limit(1) , $sortOrder);
                    break;
                case 'project':
                    $q->orderBy( Project::select('title')->whereColumn('id', 'site_visits.project_id')->limit(1) , $sortOrder);
                    break;
                case 'property':
                    $q->orderBy( Property::select('name')->whereColumn('id', 'site_visits.property_id')->limit(1) , $sortOrder);
                    break;
                case 'source_manager':
                    $q->orderBy( User::select('name')->whereColumn('id', 'site_visits.source_manager')->limit(1) , $sortOrder);
                    break;
                case 'closing_manager':
                    $q->orderBy( User::select('name')->whereColumn('id', 'site_visits.closing_manager')->limit(1) , $sortOrder);
                    break;
                case 'assign_to':
                    $q->orderBy( User::select('name')->whereColumn('id', 'site_visits.assign_to')->limit(1) , $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'site_visits.updated_by')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'location':
                    $q->orderBy( 'location' , $sortOrder);
                    break;
                case 'visit_type':
                    $q->orderBy( 'visit_type' , $sortOrder);
                    break;
                case 'time_in':
                    $q->orderBy( 'time_in' , $sortOrder);
                    break;
                case 'time_out':
                    $q->orderBy( 'time_out' , $sortOrder);
                    break;
                case 'lead_status':
                    $q->orderBy( 'lead_status' , $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeFilterSiteNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('site_name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterLocationLike ( $q, $value, $boolean = 'and' ){
        return $q->where('location', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterVisitType ( $q, $value, $boolean = 'and' ){
        return $q->where('visit_type', '=', $value, $boolean);
    }

    public function scopeFilterType ( $q, $value, $boolean = 'and' ){
        return $q->where('type', '=', $value, $boolean);
    }

    public function scopeFilterSourceManager ( $q, $value, $boolean = 'and' ){
        return $q->where('source_manager', '=', $value, $boolean);
    }

    public function scopeFilterClosingManager ( $q, $value, $boolean = 'and' ){
        return $q->where('closing_manager', '=', $value, $boolean);
    }


    public function scopeFilterProjects ( $q, $value, $boolean = 'and' ){

        if( is_array( $value ) ){
            return $q->whereIn( 'project_id', $value, $boolean );
        }
        return $q->where('project_id', '=', $value, $boolean);
    }

    public function scopeFilterProperties ( $q, $value, $boolean = 'and' ){
        if( is_array( $value ) ){
            return $q->whereIn( 'property_id', $value, $boolean );
        }
        return $q->where('property_id', '=', $value, $boolean);
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $siteName = data_get( $filter, 'site_name' );
            $companyBranch = data_get( $filter, 'company_branch' );
            $location = data_get( $filter, 'location' );
            $sourceManager = data_get( $filter, 'source_manager' );
            $closingManager = data_get( $filter, 'closing_manager' );
            $properties = data_get( $filter, 'properties' );
            $projects = data_get( $filter, 'projects' );
            $visitType = data_get( $filter, 'visit_type' );
            $assignTo = data_get( $filter, 'assign_to' );
            $updatedAt = data_get( $filter, 'updated_at' );

            if( !empty( $siteName ) ){
                $q->filterSiteNameLike( $siteName );
            }
            if( !empty( $companyBranch ) ){
                $q->filterCompanyBranch( $companyBranch );
            }
            if( !empty( $location ) ){
                $q->filterLocationLike( $location );
            }
            if( !empty( $sourceManager ) ){
                $q->filterSourceManager( $sourceManager );
            }
            if( !empty( $closingManager ) ){
                $q->filterClosingManager( $closingManager );
            }
            if( !empty( $visitType ) ){
                $q->filterVisitType( $visitType );
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

}

