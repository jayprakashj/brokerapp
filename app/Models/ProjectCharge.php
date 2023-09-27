<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;

class ProjectCharge extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function project(){
        return $this->belongsTo( Project::class, 'project_id', 'id' );
    }
}
