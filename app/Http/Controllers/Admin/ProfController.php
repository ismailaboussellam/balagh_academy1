<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTeacher;
use App\Models\Filier;
use App\Models\Groupe;
use Illuminate\Support\Facades\Hash;
// export fichie excel 
use App\Exports\TeacherStudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProfController extends Controller
{
    public function index()
    {
        $profs = User::where('role', 'teacher')
            ->whereHas('teacher')
            ->with('teacher.filiers', 'teacher.groupes')
            ->get();
        $filiers = Filier::all();
        $groupes = Groupe::all();
        return view('admin.teachers', compact('profs', 'filiers', 'groupes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        // 1. Create user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);
        // 2. Create user_teacher
        $teacher = UserTeacher::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        // 3. Attach filiers/groupes
        if ($request->filiers) $teacher->filiers()->attach($request->filiers);
        if ($request->groupes) $teacher->groupes()->attach($request->groupes);

        return redirect()->back()->with('success', 'تمت إضافة الأستاذ بنجاح');
    }

    public function update(Request $request, $id)
    {
        $teacher = UserTeacher::findOrFail($id);
        $user = $teacher->user;
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $user->update(['email' => $request->email]);
        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);
        $teacher->filiers()->sync($request->filiers ?? []);
        $teacher->groupes()->sync($request->groupes ?? []);
        return redirect()->back()->with('success', 'تم تعديل الأستاذ بنجاح');
    }

    public function destroy($id)
    {
        $teacher = UserTeacher::findOrFail($id);
        $teacher->filiers()->detach();
        $teacher->groupes()->detach();
        $teacher->user->delete();
        $teacher->delete();
        return redirect()->back()->with('success', 'تم حذف الأستاذ بنجاح');
    }
    // export fichie excel 
    

// ...

public function export($id)
{
    return Excel::download(new TeacherStudentsExport($id), 'teacher-students.xlsx');
}
}