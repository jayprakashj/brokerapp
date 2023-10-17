<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SavedSearch;
use App\Services\Database\SaveSearchClass;
use Illuminate\Http\Request;

class SavedSearchController extends Controller
{
    private $saveSearchClass;

    public function __construct( )
    {
        $this->saveSearchClass = new SaveSearchClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();

        $lists = $this->saveSearchClass->getSearchList( $request, $user);

        return response()->json( $lists, 200 );
    }

    public function store ( Request $request ) {
        $response = [
            'message' => 'Success! Selected search criteria sabved successfully.'
        ];
        $code = 200;

        $this->saveSearchClass->create( $request, auth()->user() );

        return response()->json( $response, $code );
    }


    public function delete ( SavedSearch $savedSearch ) {
        $code = 500;

        $this->saveSearchClass->removeSavedSearch( $savedSearch, auth()->user() );

        $response = [
            'message' => 'Saved search removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

}
