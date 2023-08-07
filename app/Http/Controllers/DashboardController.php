<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct( )
    {

    }

    public function viewDashboard () {
        return view('dashboard');
    }
}
