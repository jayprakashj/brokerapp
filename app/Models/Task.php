<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function assignToUser (){
        return $this->belongsTo( User::class, 'assign_to', 'id');
    }

    public function scopeCreatedByOrAssignedToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignedToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function isAssignedToMe(){
        return $this->assign_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Task List') && $this->isAssignedToMe()));
    }
}
