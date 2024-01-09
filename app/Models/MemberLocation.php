<?php

namespace App\Models;

use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;

class MemberLocation extends Model
{
    use CreatedUpdatedUserRelation, OwnerUserRelation;

    public $casts = [
        'location_time' => 'date'
    ];
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function user () {
        return $this->belongsTo( User::class, 'user_id', 'id');
    }


    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
            }
        }

        return $q;
    }


}
