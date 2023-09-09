<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia,CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }


    public function property () {
        return $this->belongsTo( Property::class, 'property_id', 'id');
    }

    public function parentDocument () {
        return $this->belongsTo( self::class, 'document_id', 'id');
    }

}
