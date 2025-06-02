<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'filier_id'];

    // groupe كينتمي filier وحدة
    public function filier()
    {
        return $this->belongsTo(Filier::class);
    }
    
    // العلاقة مع الأساتذة
    public function teachers()
    {
        return $this->belongsToMany(UserTeacher::class, 'groupe_teacher');
    }

    public function students() {
        return $this->belongsToMany(UserStudent::class, 'groupe_student', 'groupe_id', 'student_id');
    }
}
