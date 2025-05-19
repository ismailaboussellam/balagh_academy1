<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function studentDashboard()
    {
        return view('dashboard.student_dashboard');
    }

    /**
     * Display the ostad dashboard.
     */
    public function ostadDashboard()
    {
        return view('dashboard.teacher_dashbord');
    }

    /**
     * Display the ab dashboard.
     */
    public function abDashboard()
    {
        $parent = Auth::user();
        $child = $parent->child; // يستعمل العلاقة لي درناها

        return view('dashboard.father_dashboard', compact('child'));    }

    /**
     * Display the admin dashboard.
     */
    public function adminDashboard()
    {
        return view('dashboard.admin_dashboard');
    }
}
