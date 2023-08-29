<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes;

    const CONFIDENTIAL_YES = 1;
    const CONFIDENTIAL_NO = 0;

    const CONFIDENTIALS = [
        self::CONFIDENTIAL_YES => 'Yes',
        self::CONFIDENTIAL_NO => 'No',
    ];

    const IS_PRIVATE_YES = 1;
    const IS_PRIVATE_NO = 0;

    const IS_PRIVATE_LIST = [
        self::IS_PRIVATE_YES => 'Yes',
        self::IS_PRIVATE_NO => 'No',
    ];

    const IS_PROTECTED_YES = 1;
    const IS_PROTECTED_NO = 0;

    const IS_PROTECTED_LIST = [
        self::IS_PROTECTED_YES => 'Yes',
        self::IS_PROTECTED_NO => 'No',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function contact () {
        return $this->belongsTo( Contact::class, 'contact_id', 'id');
    }


    public function assignToUser (){
        return $this->belongsTo( User::class, 'assigned_to', 'id');
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function comments (){
        return $this->hasMany( LeadComment::class, 'lead_id', 'id');
    }

    public function latestComments (){
        return $this->comments()->latest();
    }

    public function scopeAssignedToAuth ( $q, $boolean = 'and' ){
        return $q->where('assigned_to', '=', auth()->id(), $boolean );
    }

    public function scopeCreatedByAuth ( $q, $boolean = 'and' ){
        return $q->where('created_by','=', auth()->id(), $boolean );
    }

    public function scopeCreatedByOrAssignedToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignedToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function isConfidential(){
        return $this->is_confidential == self::CONFIDENTIAL_YES;
    }

    public function isPrivate(){
        return $this->is_private == self::IS_PRIVATE_YES;
    }

    public function isProtected(){
        return $this->is_protected == self::IS_PROTECTED_YES;
    }

    public function isAssignedToMe(){
        return $this->assigned_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Lead List') && $this->isAssignedToMe()));
    }
}
