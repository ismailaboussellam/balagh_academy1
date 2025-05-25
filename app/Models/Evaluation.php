<?php
// app/Models/Evaluation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'lesson_id', 'score'];

    public function teacher()
{
    return $this->belongsTo(User::class, 'teacher_id');
}
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
