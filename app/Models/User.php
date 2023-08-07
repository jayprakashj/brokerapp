<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasActive, HasRoles;

    protected $with = ['defaultCompany', 'globalRole.permissions'];

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
        return $this->belongsToMany( Company::class, CompanyUserPivot::class, 'user_id','company_id','id', 'id')->withPivot('is_default')->latest();
    }

    public function defaultCompany () {
        return $this->associatedCompanies()->wherePivot('is_default', 1 );
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
        return $this->defaultCompany->first();
    }

    public function hasGlobalPermission ( $permission, $guard = null ){
        $permission = $this->globalRole->first();
        if( $permission ){
            return $permission->hasPermission( $permission, $guard );
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
        $this->assignRole('company-admin');
    }
}
