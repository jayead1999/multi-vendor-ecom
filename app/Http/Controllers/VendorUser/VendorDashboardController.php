<?php

namespace App\Http\Controllers\VendorUser;

use App\Http\Controllers\Controller;

class VendorDashboardController extends Controller
{
    public function index()
    {
        return view('vendor_user.dashboard.index');
    }
}
