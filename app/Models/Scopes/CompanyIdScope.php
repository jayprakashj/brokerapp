<?php

namespace App\Models\Scopes;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Helper;

class CompanyIdScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        //
        $defaultCompany = Helper::retrieveDefaultCompany();
        if( $defaultCompany ){
            $builder->where('company_id', $defaultCompany->id );

        }else{

            $builder->where('company_id', (Company::first()->id ?? null ));
        }
    }
}
