<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function executive()
    {
        return Inertia::render('Dashboards/Executive');
    }

    public function teamLeader()
    {
        return Inertia::render('Dashboards/TeamLeader');
    }

    public function geoHead()
    {
        return Inertia::render('Dashboards/GeoHead');
    }

    public function vicePresident()
    {
        return Inertia::render('Dashboards/VicePresident');
    }

    public function admin()
    {
        return Inertia::render('Dashboards/Admin');
    }

    public function hr()
    {
        return Inertia::render('Dashboards/HR');
    }
}
