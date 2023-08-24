<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\ContactType;

class ContactTypeClass {

    public function getLists ( $perPage = 24 ) {
        $lists = ContactType::all();
        return $lists;
    }

    public function getByName ( $keyword ) {
        $lists = ContactType::where('name', 'LIKE', '%'. $keyword .'%' )->get();
        return $lists;
    }


    public function findOrCreate ( User $user, $keyword ) {

        $contactType = $this->find( $keyword );
        if( is_null( $contactType ) ){
            $contactType = $this->create( $user, $keyword );
        }
        return $contactType;
    }

    public function find ( $keyword ){
        return ContactType::find( $keyword );
    }

    public function create( User $user, $keyword ){
        $contactType = new ContactType();
        $contactType->name = $keyword;
        $contactType->user_id = $user->id;
        $contactType->company_id = \Helper::retrieveDefaultCompany()->id;
        $contactType->updated_by = $user->id;
        $contactType->created_by = $user->id;
        $contactType->save();


        return $contactType;
    }

}
