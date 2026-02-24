<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/dashboard/index');
    }
}
