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

class Property extends Model implements HasMedia
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, InteractsWithMedia, CommonFilter;

    const IS_VERIFIED_YES = 1;
    const IS_VERIFIED_NO = 0;

    const IS_VERIFIED_LIST = [
        self::IS_VERIFIED_YES => 'Yes',
        self::IS_VERIFIED_NO => 'No',
    ];

    const IS_DOCUMENT_VERIFIED_YES = 1;
    const IS_DOCUMENT_VERIFIED_NO = 0;

    const IS_DOCUMENT_VERIFIED_LIST = [
        self::IS_DOCUMENT_VERIFIED_YES => 'Yes',
        self::IS_DOCUMENT_VERIFIED_NO => 'No',
    ];

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

    public function leads (){
        return $this->belongsToMany( Lead::class, 'lead_property_pivot', 'property_id', 'lead_id');
    }

    public function latestLeads (){
        return $this->leads()->latest();
    }

    public function documents (){
        return $this->hasMany( Document::class, 'property_id', 'id');
    }

    public function siteVisits (){
        return $this->hasMany( SiteVisit::class, 'property_id', 'id');
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
                case 'name':
                    $q->orderBy( 'name', $sortOrder);
                    break;
                case 'company_name':
                    $q->orderBy( Company::select('name')->whereColumn('id', 'properties.company_id')->limit(1) , $sortOrder);
                    break;
                case 'company_branch':
                    $q->orderBy( CompanyBranch::select('name')->whereColumn('id', 'properties.company_branch_id')->limit(1) , $sortOrder);
                    break;
                case 'assign_to':
                    $q->orderBy( User::select('name')->whereColumn('id', 'properties.assign_to')->limit(1) , $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'properties.updated_by')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'city':
                    $q->orderBy( 'city' , $sortOrder);
                    break;
                case 'locality':
                    $q->orderBy( 'locality' , $sortOrder);
                    break;
                case 'property_type':
                    $q->orderBy( 'property_type' , $sortOrder);
                    break;
                case 'property_transaction':
                    $q->orderBy( 'property_transaction' , $sortOrder);
                    break;
                case 'is_verified':
                    $q->orderBy( 'is_verified' , $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeFilterPropertyNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterCityLike ( $q, $value, $boolean = 'and' ){
        return $q->where('city', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterLocalityLike ( $q, $value, $boolean = 'and' ){
        return $q->where('locality', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterPropertyType ( $q, $value, $boolean = 'and' ){
        return $q->where('property_type', '=', $value, $boolean);
    }

    public function scopeFilterPropertyTransaction ( $q, $value, $boolean = 'and' ){
        return $q->where('property_transaction', '=',$value, $boolean);
    }

    public function scopeFilterIsVerified ( $q, $value, $boolean = 'and' ){
        return $q->where('is_verified', '=', $value, $boolean);
    }


    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $propertyName = data_get( $filter, 'name' );
            $companyBranch = data_get( $filter, 'company_branch' );
            $city = data_get( $filter, 'city' );
            $locality = data_get( $filter, 'locality' );
            $propertyType = data_get( $filter, 'property_type' );
            $propertyTransaction = data_get( $filter, 'property_transaction' );
            $isVerified = data_get( $filter, 'is_verified' );
            $assignTo = data_get( $filter, 'assign_to' );
            $updatedBy = data_get( $filter, 'updated_by' );
            $updatedAt = data_get( $filter, 'updated_at' );

            if( !empty( $propertyName ) ){
                $q->filterPropertyNameLike( $propertyName );
            }
            if( !empty( $companyBranch ) ){
                $q->filterCompanyBranch( $companyBranch );
            }
            if( !empty( $city ) ){
                $q->filterCityLike( $city );
            }
            if( !empty( $locality ) ){
                $q->filterLocalityLike( $locality );
            }
            if( !empty( $propertyType ) ){
                $q->filterPropertyType( $propertyType );
            }
            if( !empty( $propertyTransaction ) ){
                $q->filterPropertyTransaction( $propertyTransaction );
            }
            if( !is_null( $isVerified ) ){
                $q->filterIsVerified( $isVerified );
            }
            if( !is_null( $assignTo ) ){
                $q->filterAssignTo( $assignTo );
            }
            if( !is_null( $updatedBy ) ){
                $q->filterUpdatedBy( $updatedBy );
            }
            if( !is_null( $updatedAt ) ){
                $dt = explode(' to ', $updatedAt);
                $q->filterDate( 'updated_at',$dt );
            }
        }

        return $q;
    }

    public function scopeCreatedByOrAssignToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function isVerified () {
        return $this->is_verified == self::IS_VERIFIED_YES;
    }

    public function isDocumentVerified () {
        return $this->is_document_verified == self::IS_DOCUMENT_VERIFIED_YES;
    }

    public function isAssignedToMe(){
        return $this->assign_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Property List') && $this->isAssignedToMe()));
    }
}
