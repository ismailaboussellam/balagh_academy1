<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\UserTeacher;
use App\Models\Cours;
use App\Models\Subject;
use App\Models\Lesson;
use App\Models\Exam;
use App\Models\Groupe;
use App\Models\Filier;
use App\Models\Emploi;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $totalStudents = UserStudent::count();
        $totalTeachers = UserTeacher::count();
        $totalCourses = Cours::count();
        $totalSubjects = Subject::count();
        $totalLessons = Lesson::count();
        $totalExams = Exam::count();
        $totalGroups = Groupe::count();
        $totalFiliers = Filier::count();
        
        // إحصائيات شهرية للطلاب الجدد
        $monthlyStudents = UserStudent::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // إحصائيات الدورات حسب النوع
        $coursesByType = Cours::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();
            
        // آخر الطلاب المسجلين
        $recentStudents = UserStudent::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // آخر الدورات المضافة
        $recentCourses = Cours::latest()
            ->take(5)
            ->get();
            
        // الإشعارات الحديثة
        $recentNotifications = Notification::latest()
            ->take(5)
            ->get();
            
        // إحصائيات الحضور الأسبوعية
        $weeklyAttendance = Emploi::select(
            DB::raw('jour as day'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('jour')
        ->get();
        
        // أكثر المواد شعبية
        $popularSubjects = Subject::withCount('lessons')
            ->orderBy('lessons_count', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers', 
            'totalCourses',
            'totalSubjects',
            'totalLessons',
            'totalExams',
            'totalGroups',
            'totalFiliers',
            'monthlyStudents',
            'coursesByType',
            'recentStudents',
            'recentCourses',
            'recentNotifications',
            'weeklyAttendance',
            'popularSubjects'
        ));
    }
    
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'students');
        
        switch($type) {
            case 'students':
                $data = UserStudent::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
                break;
                
            case 'courses':
                $data = Cours::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();
                break;
                
            default:
                $data = collect();
        }
        
        return response()->json($data);
    }
}