<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, InteractsWithMedia, CommonFilter;


    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function registerMediaCollections(Media $media = null): void
    {
        $this
            ->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CONTAIN, 150, 150)
            ->nonQueued();
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CONTAIN, 1024)
            ->nonQueued();
    }


    public function assignToUser (){
        return $this->belongsTo( User::class, 'assign_to', 'id');
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function projectTowers (){
        return $this->hasMany( ProjectTower::class, 'project_id', 'id');
    }

    public function projectPlans (){
        return $this->hasMany( ProjectPlan::class, 'project_id', 'id');
    }

    public function projectCharges (){
        return $this->hasMany( ProjectCharge::class, 'project_id', 'id');
    }

    public function siteVisits (){
        return $this->hasMany( SiteVisit::class, 'project_id', 'id');
    }

    public function leads (){
        return $this->belongsToMany( Lead::class, 'lead_project_pivot', 'project_id', 'lead_id');
    }

    public function latestLeads (){
        return $this->leads()->latest();
    }

    public function scopeAssignToAuth ( $q, $boolean = 'and' ){
        return $q->where('assign_to', '=', auth()->id(), $boolean );
    }

    public function scopeCreatedByAuth ( $q, $boolean = 'and' ){
        return $q->where('created_by','=', auth()->id(), $boolean );
    }

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'title':
                    $q->orderBy( 'title', $sortOrder);
                    break;
                case 'project_no':
                    $q->orderBy( 'project_no', $sortOrder);
                    break;
                case 'city':
                    $q->orderBy( 'city', $sortOrder);
                    break;
                case 'company_branch':
                    $q->orderBy( CompanyBranch::select('name')->whereColumn('id', 'projects.company_branch_id')->limit(1) , $sortOrder);
                    break;
                case 'assign_to':
                    $q->orderBy( User::select('name')->whereColumn('id', 'projects.assign_to')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $title = data_get( $filter, 'title' );
            $companyBranch = data_get( $filter, 'company_branch' );
            $assignTo = data_get( $filter, 'assign_to' );
            $city = data_get( $filter, 'city' );
            if( !empty( $title ) ){
                $q->filterTitleLike( $title );
            }
            if( !empty( $companyBranch ) ){
                $q->filterCompanyBranch( $companyBranch );
            }
            if( !is_null( $assignTo ) ){
                $q->filterAssignTo( $assignTo );
            }
            if( !empty( $city ) ){
                $q->filterCityLike( $city );
            }
        }
        return $q;
    }

    public function scopeFilterTitleLike ( $q, $value, $boolean = 'and' ){
        return $q->where('title', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterCityLike ( $q, $value, $boolean = 'and' ){
        return $q->where('city', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeCreatedByOrAssignToAuth ( $q ){
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
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Project List') && $this->isAssignedToMe()));
    }
}
