<?php

namespace App\Exports;

use App\Models\UserTeacher;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherStudentsExport implements FromCollection, WithHeadings
{
    protected $teacherId;

    public function __construct($teacherId)
    {
        $this->teacherId = $teacherId;
    }

    public function collection()
    {
        $teacher = UserTeacher::with('user')->find($this->teacherId);

        if (!$teacher) return collect([]);

        // Get students from teacher's groups
        $students = collect();
        foreach ($teacher->groupes as $groupe) {
            foreach ($groupe->students as $student) {
                $students->push([
                    'الأستاذ' => $teacher->first_name . ' ' . $teacher->last_name,
                    'الطالب' => $student->first_name . ' ' . $student->last_name,
                    'البريد الإلكتروني' => $student->user->email,
                    'المجموعة' => $groupe->name,
                ]);
            }
        }

        return $students;
    }

    public function headings(): array
    {
        return ['الأستاذ', 'الطالب', 'البريد الإلكتروني', 'المجموعة'];
    }
}