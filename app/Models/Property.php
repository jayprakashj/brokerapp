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

class Property extends Model implements HasMedia
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, InteractsWithMedia;

    const IS_VERIFIED_YES = 1;
    const IS_VERIFIED_NO = 1;

    const IS_VERIFIED_LIST = [
        self::IS_VERIFIED_YES => 1,
        self::IS_VERIFIED_NO => 0,
    ];

    const IS_DOCUMENT_VERIFIED_YES = 1;
    const IS_DOCUMENT_VERIFIED_NO = 1;

    const IS_DOCUMENT_VERIFIED_LIST = [
        self::IS_DOCUMENT_VERIFIED_YES => 1,
        self::IS_DOCUMENT_VERIFIED_NO => 0,
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
        $this
            ->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CONTAIN, 150, 150)
            ->nonQueued();
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CONTAIN, 1024)
            ->nonQueued();
    }


    public function assignToUser (){
        return $this->belongsTo( User::class, 'assign_to', 'id');
    }

    public function companyBranch (){
        return $this->belongsTo( CompanyBranch::class, 'company_branch_id', 'id');
    }


    public function isVerified () {
        return $this->is_verified == self::IS_VERIFIED_YES;
    }

    public function isDocumentVerified () {
        return $this->is_document_verified == self::IS_DOCUMENT_VERIFIED_YES;
    }

}
