<?php

namespace App\Models;

use App\Models\Scopes\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Helper;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        HasActive,
        InteractsWithMedia;

    protected $defaultImage = '/images/user-placeholder.png';

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection('logo')
                ->singleFile()
                ->registerMediaConversions(function (Media $media) {
                    $this
                        ->addMediaConversion('logo')
                        ->fit(Manipulations::FIT_FILL, 150, 150)
                        ->nonQueued();
                });
    }

    public function owner () {
        return $this->belongsTo( User::class, 'owned_by', 'id');
    }

    public function associatedUsers () {
        return $this->hasManyThrough( User::class, CompanyUserPivot::class, 'company_id','id','id', 'user_id')->latest();
    }

    public function members () {
        return $this->hasMany( CompanyMember::class, 'company_id', 'id' );
    }

    public function authMember () {
        return $this->hasOne( CompanyMember::class, 'company_id', 'id' )->byAuthUser();
    }

    public function getOwnerName () {
        if( $this->owned_by == auth()->id() ){
            return 'You';
        }else{
            return $this->owner->name;
        }
    }


    public function scopeOwnedByAuthUser ( $q ){
        return $q->whereOwnedBy( auth()->id() );
    }

    public function scopeFilterCurrentDefaultCompany ( $q ){
        $defaultCompany = Helper::retrieveDefaultCompany();
        if( !is_null( $defaultCompany ) ){

            return $q->whereId( $defaultCompany->id );
        }
        return $q->whereId( null );
    }

    public function isOwnedByMe () {
        return ( $this->owned_by == auth()->id() );
    }

    public function isDefault() {
        if( $this->authMember ){
            return $this->authMember->isDefault();
        }
        return false;
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

    public function isLeadNotificationOn(){
        return $this->enable_lead_notification == 1;
    }

    public function isPropertyNotificationOn(){
        return $this->enable_property_notification == 1;
    }

    public function leadEmailsArr () {
        return explode( ',', $this->lead_email );
    }

    public function propertyEmailsArr () {
        return explode( ',', $this->property_email );
    }
}
