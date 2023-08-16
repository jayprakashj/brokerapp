<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CompanyMember extends Model
{
    use HasFactory;

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

    public function memberUser () {
        return $this->belongsTo( User::class, 'user_id', 'id');
    }

    public function company () {
        return $this->belongsTo( Company::class, 'company_id', 'id');
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

    public function scopeCurrentDefaultCompany ( $q ){
        $defaultCompany = \Helper::retrieveDefaultCompany();
        if( !is_null( $defaultCompany ) ){

            return $q->whereCompanyId( $defaultCompany->id );
        }
        return $q;
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
