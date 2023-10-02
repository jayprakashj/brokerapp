<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyBranch extends Model
{
    use SoftDeletes, CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation;

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


    public function getNameWithCompanyName () {
        $name = $this->name;
        if( !is_null( $this->company ) ){
            $name .= '( ' . $this->company->name . ' )';
        }
        return $name;
    }

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'name':
                    $q->orderBy( 'name', $sortOrder);
                    break;
                case 'updated_by':
                    $q->orderBy( User::select('name')->whereColumn('id', 'company_branches.updated_by')->limit(1) , $sortOrder);
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

}
