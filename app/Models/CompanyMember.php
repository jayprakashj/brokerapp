<?php

namespace App\Models;

use App\Models\Scopes\CommonFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class CompanyMember extends Model
{
    use HasFactory, SoftDeletes, CommonFilter;

    const INVITE_STATUS_PENDING = 0;
    const INVITE_STATUS_ACCEPT = 1;

    const FLAG_IS_OWNER_NO = 0;
    const FLAG_IS_OWNER_YES = 1;

    const FLAG_IS_DEFAULT_NO = 0;
    const FLAG_IS_DEFAULT_YES = 1;

    const IS_OWNER_FLAGS = [
        self::FLAG_IS_OWNER_YES => 'Yes',
        self::FLAG_IS_OWNER_NO => 'No',
    ];

    const IS_DEFAULT_FLAGS = [
        self::FLAG_IS_DEFAULT_YES => 'Yes',
        self::FLAG_IS_DEFAULT_NO => 'No',
    ];

    const INVITE_STATUSES = [
        self::INVITE_STATUS_PENDING => 'Pending',
        self::INVITE_STATUS_ACCEPT => 'Accept',
    ];


    /**
     * The "booted" method of the model.
     */
    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new CompanyIdScope);
    // }


    public function memberUser () {
        return $this->belongsTo( User::class, 'user_id', 'id');
    }

    public function company () {
        return $this->belongsTo( Company::class, 'company_id', 'id');
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function authDefaultCompany () {
        return $this->defaultCompany()->ownedByAuthUser();
    }

    public function owner () {
        return $this->company()->ownedByAuthUser();
    }

    public function role () {
        return $this->belongsTo( Role::class, 'role_id', 'id');
    }

    public function createdUser () {
        return $this->belongsTo( User::class, 'created_by', 'id');
    }

    public function scopeByAuthUser ( $q, $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        return $q->whereUserId( $user->id );
    }

    public function scopePendingInvite ( $q ){
        return $q->whereInviteStatus( self::INVITE_STATUS_PENDING );
    }

    public function scopeAcceptedInvite ( $q ){
        return $q->whereInviteStatus( self::INVITE_STATUS_ACCEPT );
    }


    public function scopeOnlyDefault ( $q ){
        return $q->whereIsDefault( self::FLAG_IS_DEFAULT_YES );
    }

    public function scopeNotOwner ( $q ){
        return $q->whereIsOwner( self::FLAG_IS_OWNER_NO );
    }

    public function scopeCurrentDefaultCompany ( $q ){
        $defaultCompany = \Helper::retrieveDefaultCompany();
        if( !is_null( $defaultCompany ) ){

            return $q->whereCompanyId( $defaultCompany->id );
        }
        return $q;
    }

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'name':
                    $q->orderBy( User::select('name')->whereColumn('id', 'company_members.user_id')->limit(1), $sortOrder);
                    break;
                case 'role':
                    $q->orderBy( Role::select('name')->whereColumn('id', 'company_members.role_id')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'company_branch':
                    $q->orderBy( CompanyBranch::select('name')->whereColumn('id', 'company_members.company_branch_id')->limit(1) , $sortOrder);
                    break;
                case 'email':
                    $q->orderBy( 'email' , $sortOrder);
                    break;
                case 'mobile':
                    $q->orderBy( User::select('mobile')->whereColumn('id', 'company_members.user_id')->limit(1), $sortOrder);
                    break;
            }
        }

        return $q;
    }


    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $name = data_get( $filter, 'name' );
            $mobile = data_get( $filter, 'mobile' );
            $email = data_get( $filter, 'email' );
            $role = data_get( $filter, 'role' );
            $companyBranch = data_get( $filter, 'company_branch' );
            if( !empty( $name ) ){
                $q->filterNameLike( $name );
            }
            if( !empty( $mobile ) ){
                $q->filterMobileLike( $mobile );
            }
            if( !empty( $email ) ){
                $q->filterEmailLike( $email );
            }
            if( !empty( $companyBranch ) ){
                $q->filterCompanyBranch( $companyBranch );
            }
            if( !empty( $role ) ){
                $q->filterRole( $role );
            }
        }
        return $q;
    }

    public function scopeFilterNameLike ( $q, $value, $boolean = 'and' ){
        return $q->{$boolean == 'or' ? 'orWhereRelation' : 'whereRelation'}('memberUser','name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterRole ( $q, $value, $boolean = 'and' ){
        return $q->where('role_id', '=', $value, $boolean);
    }

    public function scopeFilterMobileLike ( $q, $value, $boolean = 'and' ){
        return $q->{$boolean == 'or' ? 'orWhereRelation' : 'whereRelation'}('memberUser','mobile', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterEmailLike ( $q, $value, $boolean = 'and' ){
        return $q->where('email', 'LIKE', '%'. $value . '%', $boolean);
    }
    public function isOwner () {
        return $this->is_owner == self::FLAG_IS_OWNER_YES;
    }

    public function isOwnerMe () {
        return $this->isOwner() && $this->isMe();
    }

    public function isMe () {
        return $this->user_id == auth()->id();
    }

    public function isAccepted () {
        return $this->invite_status == self::INVITE_STATUS_ACCEPT;
    }

    public function isPending () {
        return $this->invite_status == self::INVITE_STATUS_PENDING;
    }

    public function isDefault () {
        return $this->is_default == self::FLAG_IS_DEFAULT_YES;
    }

}
