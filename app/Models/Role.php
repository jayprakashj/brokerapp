<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CompanyIdScope;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use CompanyRelation, OwnerUserRelation;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }


    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'name':
                    $q->orderBy( 'name', $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $name = data_get( $filter, 'name' );
            $permissions = data_get( $filter, 'permissions' );
            $member = data_get( $filter, 'member' );
            if( !empty( $name ) ){
                $q->filterNameLike( $name );
            }
            if( !empty( $permissions ) ){
                $q->filterPermission( $permissions );
            }
            if( !empty( $member ) ){
                $q->filterMember( $member );
            }
        }
        return $q;
    }

    public function scopeFilterNameLike ( $q, $value, $boolean = 'and' ){
        return $q->where('name', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterPermission ( $q, $value, $boolean = 'and' ){
        if( !empty( $value ) ) {
            if( is_array( $value ) ){
                return $q->{$boolean == 'or' ? 'whereHas' : 'orWhereHas'}('permissions', function( $subQry ) use ( $value ){
                    $subQry->whereIn('id', $value);
                });
            }else{
                $q->{$boolean == 'or' ? 'whereRelation' : 'orWhereRelation'}('permissions', 'id', '=', $value);
            }
        }
        return $q;
    }

    public function scopeFilterMember ( $q, $value, $boolean = 'and' ){
        if( !empty( $value ) ) {
            $q->{$boolean == 'or' ? 'whereRelation' : 'orWhereRelation'}('users', 'id', '=', $value);
        }
        return $q;
    }

}
