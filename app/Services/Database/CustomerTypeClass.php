<?php

namespace App\Services\Database;

use App\Models\User;
use Illuminate\Support\Str;
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
        if( is_null( $customerType ) && !empty( $keyword ) ){
            $customerType = $this->create( $user, $keyword );
        }
        return $customerType;
    }

    public function find ( $keyword ){
        return CustomerType::find( $keyword );
    }

    public function create( User $user, $keyword ){
        $customerType = new CustomerType();
        $customerType->name = Str::title( $keyword );
        $customerType->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $customerType->company_id = \Helper::retrieveDefaultCompany()->id;
        $customerType->updated_by = $user->id;
        $customerType->created_by = $user->id;
        $customerType->save();


        return $customerType;
    }

}
