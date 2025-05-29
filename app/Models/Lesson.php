<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'teacher_id', 'subject_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'lesson_id');
    }
}
