<?php

namespace App\Services\Database;

use App\Models\SavedSearch;
use App\Models\User;

class SaveSearchClass {

    public function getSearchList ( $request, $user  ){
        $lists = SavedSearch::where('user_id', $user->id)
                            ->whereType( $request->input('type') )
                            ->get();
        return $lists;
    }

    public function create ( $request, User $user) {

        $savedSearch = new SavedSearch();
        $savedSearch->user_id = $user->id;
        $savedSearch->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $savedSearch->type = $request->input('type', 'lead');
        $savedSearch->search_data = $request->input('search_data');
        $savedSearch->save();
    }

    public function removeSavedSearch ( SavedSearch $savedSearch, User $user ) {

        if( $savedSearch->user_id == $user->id ){
            $savedSearch->delete();
        }

        return true;

    }


}
