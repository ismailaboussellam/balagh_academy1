<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeacherStudentsExport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('export.index', compact('teachers'));
    }

    public function export(Request $request)
    {
        $teacherId = $request->input('teacher_id');
        return Excel::download(new TeacherStudentsExport($teacherId), 'teacher_students.xlsx');
    }
}
