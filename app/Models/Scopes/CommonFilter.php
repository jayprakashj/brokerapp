<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\DB;

trait CommonFilter {

    // public function scopeFilterCompanyBranch ( $q, $value, $boolean = 'and' ){
    //     return $q->{$boolean == 'or' ? 'whereRelation' : 'orWhereRelation'}('companyBranch', 'id', '=', $value);
    // }

    public function scopeFilterCompanyBranch ( $q, $value, $boolean = 'and' ){
        return $q->where('company_branch_id', '=', $value, $boolean);
    }

    public function scopeFilterAssignTo ( $q, $value, $boolean = 'and' ){
        return $q->where('assign_to', '=', $value, $boolean);
    }

    public function scopeFilterUpdatedBy ( $q, $value, $boolean = 'and' ){
        return $q->where('updated_by', '=', $value, $boolean);
    }

    public function scopeFilterDate ( $q, $column, $value ){
        if( !empty( $value ) && is_array( $value ) ){
            if( is_array( $value ) ){
                if( count( $value ) == 2 ){
                    return $q->whereBetween( DB::Raw( 'DATE('.$column.')'), $value);
                }
                if( count( $value ) == 1 ){
                    return $q->whereDate( $column, $value);
                }

            }else{

                return $q->whereDate( $column, $value);
            }
        }
        return $q;
    }
}
