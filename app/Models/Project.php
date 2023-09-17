<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, InteractsWithMedia;


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

    public function scopeAssignToAuth ( $q, $boolean = 'and' ){
        return $q->where('assign_to', '=', auth()->id(), $boolean );
    }

    public function scopeCreatedByAuth ( $q, $boolean = 'and' ){
        return $q->where('created_by','=', auth()->id(), $boolean );
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
