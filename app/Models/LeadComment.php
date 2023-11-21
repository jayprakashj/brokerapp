<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadComment extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, CommonFilter;

    const WON_LEAD_STATUS = 'Won';
    const OPPERTUNITY_LEAD_STATUS = 'Qualified';
    const QUALIFIED_LEAD_STATUS = 'Qualified';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function lead (){
        return $this->belongsTo( Lead::class, 'lead_id', 'id');
    }


    public function scopeFilterLeadStatus ( $q, $value, $boolean = 'and' ){
        return $q->where('lead_status', '=', $value, $boolean);
    }


    public function scopeWonLeadStatus ( $q, $boolean = 'and' ){
        return $q->filterLeadStatus( self::WON_LEAD_STATUS, $boolean);
    }

    public function scopeOppertunitiesLeadStatus ( $q, $boolean = 'and' ){
        return $q->filterLeadStatus( self::OPPERTUNITY_LEAD_STATUS, $boolean);
    }

    public function scopeQualifiedLeadStatus ( $q, $boolean = 'and' ){
        return $q->filterLeadStatus( self::QUALIFIED_LEAD_STATUS, $boolean);
    }
}
