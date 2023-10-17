<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;

class SavedSearch extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation;

    protected $casts = [
        'search_data' => 'json'
    ];
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }


    public function scopeForLead( $q ){
        return $q->where('type', 'lead');
    }
}
