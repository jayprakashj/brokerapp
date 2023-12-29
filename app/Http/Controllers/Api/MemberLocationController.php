<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberLocationRequest;
use App\Http\Resources\Api\MemberLocationHistory\MemberLocationHistoryListResource;
use App\Http\Resources\Api\Member\MemberPaginationResource;
use App\Models\User;
use App\Services\Database\MemberLocationClass;
use Illuminate\Http\Request;

class MemberLocationController extends Controller
{
    private $memberLocationClass;

    public function __construct( MemberLocationClass $memberLocationClass )
    {
        $this->memberLocationClass = $memberLocationClass;
    }

    public function index ( Request $request ) {

        $members = $this->memberLocationClass->getDefaultCompanyMembers( $request );

        return new MemberPaginationResource( $members );
    }

    public function store (AddMemberLocationRequest $request ) {
        $response = [
            'message' => 'Success! Location captured successfully.'
        ];
        $code = 200;

        $this->memberLocationClass->createMany(  auth()->user(), $request->input('locations', []) );

        return response()->json( $response, $code );
    }

    public function getMemberLocationHistory( User $user ){
        $code = 200;

        $locations = $this->memberLocationClass->fetchLocationHistory( $user );
        $response = [
            'message' => 'Success! Location captured successfully.',
            'locations' => MemberLocationHistoryListResource::collection( $locations )->additional(['selectedUser' => $user])
        ];

        return response()->json( $response, $code );
    }
}
