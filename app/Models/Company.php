<?php

namespace App\Models;

use App\Models\Scopes\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, HasActive;

    public function owner () {
        return $this->belongsTo( User::class, 'owned_by', 'id');
    }

    public function associatedUsers () {
        return $this->hasManyThrough( User::class, CompanyUserPivot::class, 'company_id','id','id', 'user_id')->latest();
    }

    public function members () {
        return $this->hasMany( CompanyMember::class, 'company_id', 'id' );
    }

    public function authMember () {
        return $this->hasOne( CompanyMember::class, 'company_id', 'id' )->byAuthUser();
    }

    public function getOwnerName () {
        if( $this->owned_by == auth()->id() ){
            return 'You';
        }else{
            return $this->owner->name;
        }
    }


    public function scopeOwnedByAuthUser ( $q ){
        return $q->whereOwnedBy( auth()->id() );
    }

    public function isOwnedByMe () {
        return ( $this->owned_by == auth()->id() );
    }

    public function isDefault() {
        if( $this->authMember ){
            return $this->authMember->isDefault();
        }
        return false;
    }
}
