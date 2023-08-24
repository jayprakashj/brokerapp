<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\CustomerType;

class CustomerTypeClass {

    public function getLists ( $perPage = 24 ) {
        $lists = CustomerType::all();
        return $lists;
    }

    public function getByName ( $keyword ) {
        $lists = CustomerType::where('name', 'LIKE', '%'. $keyword .'%' )->get();
        return $lists;
    }


    public function findOrCreate ( User $user, $keyword ) {

        $customerType = $this->find( $keyword );
        if( is_null( $customerType ) ){
            $customerType = $this->create( $user, $keyword );
        }
        return $customerType;
    }

    public function find ( $keyword ){
        return CustomerType::find( $keyword );
    }

    public function create( User $user, $keyword ){
        $customerType = new CustomerType();
        $customerType->name = $keyword;
        $customerType->user_id = $user->id;
        $customerType->company_id = \Helper::retrieveDefaultCompany()->id;
        $customerType->updated_by = $user->id;
        $customerType->created_by = $user->id;
        $customerType->save();


        return $customerType;
    }

}
