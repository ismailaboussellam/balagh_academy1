<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function studentDashboard()
    {
        return view('dashboard.student_dashboard');
    }
    public function teacherDashboard()
    {
        return view('dashboard.teacher_dashbord');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin_dashboard');
    }
}
