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

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }

    public function property () {
        return $this->belongsTo( Property::class, 'property_id', 'id');
    }

    public function parentDocument () {
        return $this->belongsTo( self::class, 'document_id', 'id');
    }


    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'name':
                    $q->orderBy( 'name', $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'documents.updated_by')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'description':
                    $q->orderBy( 'description' , $sortOrder);
                    break;
            }
        }

        return $q;
    }


    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $name = data_get( $filter, 'name' );
            if( !empty( $name ) ){
                $q->filterNameLike( $name );
            }
        }
        return $q;
    }

    public function scopeFilterNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('name', 'LIKE', '%'. $value . '%', $boolean);
    }

}
