<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Contact extends Model implements HasMedia
{
    use SoftDeletes,InteractsWithMedia,CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, CommonFilter;

    protected $defaultImage = '/images/100x100.png';

    const NAME_PREFIX_LIST = [
        'Mr.' => 'Mr.',
        'Mrs.' => 'Mrs.',
        'Miss' => 'Miss',
        'Ms.' => 'Ms.',
    ];

    const OCCUPATION_LIST = [
        'Business' => 'Business',
        'Job' => 'Job',
    ];
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

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'name':
                    $q->orderBy( 'name', $sortOrder);
                    break;
                case 'contact_type':
                    $q->orderBy( ContactType::select('name')->whereColumn('id', 'contacts.contact_type_id')->limit(1) , $sortOrder);
                    break;
                case 'customer_type':
                    $q->orderBy( CustomerType::select('name')->whereColumn('id', 'contacts.customer_type_id')->limit(1) , $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'contacts.updated_by')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
                case 'city':
                    $q->orderBy( 'city' , $sortOrder);
                    break;
                case 'email':
                    $q->orderBy( 'email' , $sortOrder);
                    break;
                case 'mobile':
                    $q->orderBy( 'mobile' , $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $name = data_get( $filter, 'name' );
            $mobile = data_get( $filter, 'mobile' );
            $email = data_get( $filter, 'email' );
            $city = data_get( $filter, 'city' );
            $gender = data_get( $filter, 'gender' );
            $contactType = data_get( $filter, 'contact_type' );
            $customerType = data_get( $filter, 'customer_type' );
            $updatedAt = data_get( $filter, 'updated_at' );
            if( !empty( $name ) ){
                $q->filterNameLike( $name );
            }
            if( !empty( $mobile ) ){
                $q->filterMobileLike( $mobile );
            }
            if( !empty( $email ) ){
                $q->filterEmailLike( $email );
            }
            if( !empty( $city ) ){
                $q->filterCityLike( $city );
            }
            if( !empty( $gender ) ){
                $q->filterGender( $gender );
            }
            if( !empty( $contactType ) ){
                $q->filterContactType( $contactType );
            }
            if( !empty( $customerType ) ){
                $q->filterCustomerType( $customerType );
            }
            if( !is_null( $updatedAt ) ){
                $dt = explode(' to ', $updatedAt);
                $q->filterDate( 'updated_at',$dt );
            }
        }
        return $q;
    }

    public function scopeFilterNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterCityLike ( $q, $value, $boolean = 'and' ){
        return $q->where('city', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterMobileLike ( $q, $value, $boolean = 'and' ){
        return $q->where('mobile', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterEmailLike ( $q, $value, $boolean = 'and' ){
        return $q->where('email', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterGender ( $q, $value, $boolean = 'and' ){
        return $q->where('gender', '=', $value, $boolean);
    }

    public function scopeFilterContactType ( $q, $value, $boolean = 'and' ){
        return $q->where('contact_type_id', '=', $value, $boolean);
    }

    public function scopeFilterCustomerType ( $q, $value, $boolean = 'and' ){
        return $q->where('customer_type_id', '=', $value, $boolean);
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
