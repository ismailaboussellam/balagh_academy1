<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filier extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // filier عندها بزاف ديال groupes
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
    
    public function teachers()
    {
        return $this->belongsToMany(UserTeacher::class, 'filier_teacher');
    }
    
    public function students() {
        return $this->belongsToMany(UserStudent::class, 'filier_student', 'filier_id', 'student_id');
    }

}