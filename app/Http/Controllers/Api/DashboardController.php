<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Database\DashboardClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $dashboardClass;

    public function __construct( )
    {
        $this->dashboardClass = new DashboardClass;
    }

    public function getDashboardData ( Request $request ) {
        $user = auth()->user();

        $data = $this->dashboardClass->dashboardData( $user, $request );

        return response()->json( $data, 200 );
    }


}
