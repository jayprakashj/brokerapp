<?php

namespace App\Services;

use App\Models\User;
use NumberFormatter;

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
            setPermissionsTeamId( $defaultCompany );
        }
    }
}
