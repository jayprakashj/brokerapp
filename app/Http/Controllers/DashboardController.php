<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SpatiePermission;

class DashboardController extends Controller
{
    public function __construct( )
    {

    }

    public function loadVueApp (){
        $globalPermissions = SpatiePermission::GlobalPermissions()->get()->pluck('name');

        return view('components.layouts.vue-app', compact( 'globalPermissions' ) );
    }

    public function viewDashboard () {
        return view('dashboard');
    }
}
