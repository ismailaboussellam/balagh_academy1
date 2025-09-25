<?php

namespace App\Exports;

use App\Models\Teacher;
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
        $teacher = Teacher::with('students')->find($this->teacherId);

        if (!$teacher) return collect([]);

        return $teacher->students->map(function ($student) use ($teacher) {
            return [
                'Teacher' => $teacher->name,
                'Student' => $student->name,
                'Email'   => $student->email,
            ];
        });
    }

    public function headings(): array
    {
        return ['Teacher', 'Student', 'Email'];
    }
}
