<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Contact extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia,CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation;

    protected $defaultImage = '/images/100x100.png';

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }


    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('logo')
                ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this
                        ->addMediaConversion('logo')
                        ->fit(Manipulations::FIT_CONTAIN, 150, 150)
                        ->nonQueued();
                });
    }


    public function contactType () {
        return $this->belongsTo( ContactType::class, 'contact_type_id', 'id');
    }

    public function customerType () {
        return $this->belongsTo( CustomerType::class, 'customer_type_id', 'id');
    }


    public function getLogoUrlAttribute () {
        return $this->getLogoUrl();
    }

    public function getLogoUrl () {
        $media = $this->media;
        if( $media->count() ){
            return  $this->getFirstMediaUrl('logo', 'logo');
        }

        return url( $this->defaultImage );
    }

    public function getLogoMediaId () {
        $media = $this->getFirstMedia('logo');
        if( !is_null( $media ) ){
            return  $media->id;
        }

        return null;
    }

    public function isGenderMale () {

        return $this->gender == 'male';
    }

    public function isGenderFemale () {

        return $this->gender == 'female';
    }

    public function isGenderOther () {

        return $this->gender == 'other';
    }
}
