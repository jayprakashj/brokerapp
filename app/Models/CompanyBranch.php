<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;

class CompanyBranch extends Model
{
    use CompanyRelation;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }


    public function ownerUser (){
        return $this->belongsTo( User::class, 'user_id', 'id');
    }

    public function createdUser (){
        return $this->belongsTo( User::class, 'created_by', 'id');
    }

    public function updatedUser (){
        return $this->belongsTo( User::class, 'updated_by', 'id');
    }


}
