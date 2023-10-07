<?php

namespace App\Services;

use App\Models\User;
use NumberFormatter;
use App\Models\Company;
use Illuminate\Support\Str;

class HelperService {

    public function convertArrayIntoAssociative ( $data = [], $idKey = 'id', $labelKey = 'title' ){
        $resArr = [];
        foreach( $data as $key => $value ){
            $tmp = [
                $idKey => $key,
                $labelKey => $value,
            ];
            $resArr[] = $tmp;
        }
        return $resArr;
    }

    public function formatAmount ( $amount, $withSymbol = true, $useMoneyFormat = false ){

        if( $useMoneyFormat ){
            $numFormat = new \NumberFormatter('en_IN', NumberFormatter::DECIMAL);
            if( $withSymbol ){
                $numFormat = new \NumberFormatter('en_IN', NumberFormatter::CURRENCY);
            }
            return $numFormat->formatCurrency( (float)$amount, 'INR' );
        }

        if( is_numeric( $amount ) ){
            $amount = number_format( $amount, 2 );
            if( $withSymbol ){
                $amount = config('app.currency_symbol') . ' ' . $amount;
            };
        }
        return $amount;
    }

    public function setDefaultCompanySessionTeam ( User $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        $defaultCompany = $user->retrieveDefaultCompany();
        if( !is_null( $defaultCompany )){
            setPermissionsTeamId( $defaultCompany->id );
        }
    }

    public function hasGlobalPermission ( $permission, $guard = null ) {
        return auth()->user()->hasGlobalPermission( $permission, $guard );
    }

    public function retrieveDefaultCompany(){
        $user = auth()->user();
        if( $user ){
            $defaultCompany = $user->retrieveDefaultCompany();
            if( !is_null( $defaultCompany ) ){
                return $defaultCompany;
            }
        }else{
            return Company::first();
        }

        return null;
    }

    public function combineKeyValue( $data ){
        $result = [];
        if( !empty( $data ) ){
            foreach( $data as $key => $value ){
                $result[] = $key . ' : ' . $value;
            }
        }

        return $result;
    }

    public function convertChangesData( $data ){
        $result = [];
        if( !empty( $data ) ){
            foreach( $data as $key => $value ){
                $key = Str::title(Str::replace('_', ' ', $key ));
                if( is_array( $value ) ){
                    $value = implode( ', ', $value );
                }
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
