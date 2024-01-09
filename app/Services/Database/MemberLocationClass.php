<?php

namespace App\Services\Database;

use App\Jobs\FetchLocationFromLatLongJob;
use App\Models\User;
use App\Models\CompanyMember;
use App\Models\MemberLocation;
use Illuminate\Http\Request;

class MemberLocationClass {

    public function getDefaultCompanyMembers ( $request ) {
        $members = CompanyMember::with([
                            'company',
                            'companyBranch',
                            'memberUser',
                            'role'
                        ])
                        ->currentDefaultCompany()
                        ->customFilter( $request->input('filter') )
                        ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                        ->paginate( $request->input('per_page', config('app.per_page') ) );
        return $members;
    }

    public function getMembersListForSelectList () {
        $members = CompanyMember::with('memberUser')->currentDefaultCompany()->get();
        return $members;
    }


    public function create ( User $user, $request ) {


        $memberLocation = new MemberLocation();
        $memberLocation->user_id = auth()->id();
        $memberLocation->company_id = \Helper::retrieveDefaultCompany()->id ?? null;

        $memberLocation = $this->createOrUpdate( $memberLocation, $user, $request );

        return $memberLocation;
    }

    public function createMany ( User $user, $data = [] ) {
        foreach( $data as $item ){

            $memberLocation = new MemberLocation();
            $memberLocation->user_id = $user->id;
            $memberLocation->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
            $req = new Request( $item );
            $memberLocation = $this->createOrUpdate( $memberLocation, $user, $req );

        }

    }

    public function update ( User $user, MemberLocation $memberLocation, $request ){
        return $this->createOrUpdate( $memberLocation, $user, $request );
    }


    public function createOrUpdate( MemberLocation $memberLocation, User $user, $request ){
        $memberLocation->latitude = $request->input('latitude');
        $memberLocation->longitude = $request->input('longitude');
        $memberLocation->location_time = $request->input('location_time', now()->format('Y-m-d H:i:S'));
        $memberLocation->save();
        dispatch( new FetchLocationFromLatLongJob( $memberLocation ) );
        return $memberLocation;
    }

    public function fetchLocationHistory( User $user ){
        $locations = MemberLocation::where('user_id', $user->id)
                                    ->where('created_at', '>=', now()->subDays(3)->startOfDay() )
                                    ->limit(500)
                                    ->orderByDesc('location_time')
                                    ->get();
        return $locations;
    }

}
