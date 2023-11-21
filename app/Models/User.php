<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use App\Models\Scopes\HasActive;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\PermissionRegistrar;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Resources\Api\Company\CompanyEditResource;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Resources\Api\Company\DefaultCompanyResource;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens,
        HasFactory,
        SoftDeletes,
        Notifiable,
        HasActive,
        HasRoles,
        InteractsWithMedia;

    protected $with = ['defaultCompany.company', 'globalRole.permissions'];

    protected $defaultImage = '/images/user-placeholder.png';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const TYPE_COMPANY = 'company';
    const TYPE_INDIVIDUAL = 'individual';

    const TYPE_LIST = [
        self::TYPE_COMPANY => 'Company',
        self::TYPE_INDIVIDUAL => 'Individual',
    ];

    protected function getDefaultGuardName() {
        return 'web';
    }

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('logo')
                ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this
                        ->addMediaConversion('logo')
                        ->fit(Manipulations::FIT_CONTAIN, 150, 150)
                        ->nonQueued();
                });
    }


    /**
     * A model may have multiple direct permissions.
     */
    public function globalRole(): BelongsToMany
    {
        $relation = $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            PermissionRegistrar::$pivotRole
        );

        if (! PermissionRegistrar::$teams) {
            return $relation;
        }

        return $relation->wherePivot(PermissionRegistrar::$teamsKey, null)
            ->where(function ($q) {
                $teamField = config('permission.table_names.roles').'.'.PermissionRegistrar::$teamsKey;
                $q->whereNull($teamField)->orWhere($teamField, null);
            });
    }

    public function ownedCompany () {
        return $this->hasOne( Company::class, 'owned_by', 'id')->latest();
    }

    public function ownedCompanies () {
        return $this->hasMany( Company::class, 'owned_by', 'id')->latest();
    }


    public function associatedCompanies () {
        // return $this->hasManyThrough( Company::class, CompanyUserPivot::class, 'user_id','id','id', 'company_id')->latest();
        // return $this->belongsToMany( Company::class, CompanyUserPivot::class, 'user_id','company_id','id', 'id')->withPivot('is_default')->latest();
        return $this->hasMany( CompanyMember::class, 'user_id', 'id');
    }

    public function acceptedCompanies (){
        return $this->associatedCompanies()->acceptedInvite();
    }

    public function defaultCompany () {
        return $this->hasOne( CompanyMember::class, 'user_id', 'id')->onlyDefault();
    }

    public function currentDefaultCompany () {
        return $this->hasOne( CompanyMember::class, 'user_id', 'id')->currentDefaultCompany();
    }

    public function companyRole () {
        return $this->hasOne( Role::class, 'user_id', 'id');
    }

    public function userRoles () {
        return $this->hasMany( Role::class, 'user_id', 'id');
    }

    public function scopeTypeCompany ( $q ) {
        return $q->whereType( self::TYPE_COMPANY );
    }

    public function scopeTypeIndividual ( $q ) {
        return $q->whereType( self::TYPE_INDIVIDUAL );
    }

    public function isTypeCompany () {
        return $this->type == self::TYPE_COMPANY;
    }

    public function isTypeIndividual () {
        return $this->type == self::TYPE_INDIVIDUAL;
    }

    public function isEmailVerified () {
        return !is_null($this->email_verified_at);
    }

    public function hasCompanyAssociates () {
        return $this->associatedCompanies->count() > 0;
    }

    public function retrieveDefaultCompany(){
        $company = $this->defaultCompany;
        if( !is_null( $company ) ){
            $company = $this->defaultCompany->company;
            if( !is_null( $company ) && $company->isActive() ){
                return $company;
            }
        }
        return null;
    }

    public function hasGlobalPermission ( $permission, $guard = null ){
        $permission = $this->globalRole->first();
        if( $permission ){
            return $permission->hasPermissionTo( $permission, $guard );
        }
        return false;
    }

    public function hasAnyGlobalPermission ( $permission){
        $permission = $this->globalRole->first();
        if( $permission ){
            return $permission->hasAnyPermission( $permission );
        }
        return false;
    }

    public function hasAllGlobalPermission ( $permission){
        $permission = $this->globalRole->first();
        if( $permission ){
            return $permission->hasAllPermissions( $permission );
        }
        return false;
    }

    public function setDefaultRole () {
        if( $this->isTypeIndividual() ){
            $this->assignRole( 'user-admin' );
        }else{
            $this->assignRole('company-admin');
        }
    }

    public function isCompanyAdmin () {
        return $this->hasRole('company-admin');
    }

    public function leads (){
        return $this->hasMany( Lead::class, 'assigned_to', 'id');
    }

    public function scopeGetDefaultLogoUrl () {

        return $this->getDefaultLogo();
    }

    public function getDefaultLogo () {

        return url( $this->defaultImage );
    }

    public function getLogoUrl () {
        $media = $this->media;
        if( $media->count() ){
            return  $this->getFirstMediaUrl('logo','logo');
        }

        return $this->getDefaultLogo();
    }

    public function getLogoMediaId () {
        $media = $this->getFirstMedia('logo');
        if( !is_null( $media ) ){
            return  $media->id;
        }

        return null;
    }

    public function getDataForVueApp () {
        $this->logo = $this->getLogoMediaId();
        $this->logo_url = $this->getLogoUrl();
        $this->role_name = Str::replace('-', ' ', Str::title( $this->getRoleNames()->first() ));
        if( !is_null( $this->defaultCompany ) && !empty( $this->defaultCompany->company ) ){
            $this->current_company = new DefaultCompanyResource( $this->defaultCompany->company );

        }

        return $this;
    }
}
