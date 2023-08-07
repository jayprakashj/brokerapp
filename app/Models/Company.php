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

    public function getOwnerName () {
        if( $this->owned_by == auth()->id() ){
            return 'You';
        }else{
            return $this->owner->name;
        }
    }

    public function isOwnedByMe () {
        return ( $this->owned_by == auth()->id() );
    }

    public function isDefault() {
        if( $this->pivot ){
            return ($this->pivot->is_default ?? 0 ) == 1;
        }
        return false;
    }
}
