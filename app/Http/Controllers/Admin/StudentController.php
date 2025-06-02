<?php

// app/Http/Controllers/Admin/StudentController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\Filier;
use App\Models\Groupe;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $groupes = Groupe::all();
        $filiers = Filier::all();

        $selectedGroupe = $request->get('groupe_id');
        $studentsQuery = UserStudent::with(['user', 'filiers', 'groupes']);

        if ($selectedGroupe) {
            $studentsQuery->whereHas('groupes', function($q) use ($selectedGroupe) {
                $q->where('groupes.id', $selectedGroupe);
            });
        }

        $students = $studentsQuery->get();

        return view('admin.students', compact('students', 'groupes', 'filiers', 'selectedGroupe'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'filier_id' => 'required|exists:filiers,id',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student',
        ]);

        $student = UserStudent::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        $student->filiers()->sync([$request->filier_id]);
        $student->groupes()->sync([$request->groupe_id]);

        return redirect()->route('admin.students.index')->with('success', 'تمت إضافة الطالب بنجاح');
    }

    public function update(Request $request, $id)
    {
        $student = UserStudent::findOrFail($id);
        $user = $student->user;

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'filier_id' => 'required|exists:filiers,id',
            'groupe_id' => 'required|exists:groupes,id',
        ]);

        $user->update([
            'email' => $request->email,
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        $student->filiers()->sync([$request->filier_id]);
        $student->groupes()->sync([$request->groupe_id]);

        return redirect()->route('admin.students.index')->with('success', 'تم تعديل الطالب بنجاح');
    }

    public function destroy($id)
    {
        $student = UserStudent::findOrFail($id);
        $student->user()->delete();
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'تم حذف الطالب بنجاح');
    }
}