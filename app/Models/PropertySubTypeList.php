<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertySubTypeList extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function propertyType () {
        return $this->belongsTo( PropertyTypeList::class, 'property_type_id', 'id');
    }
}
