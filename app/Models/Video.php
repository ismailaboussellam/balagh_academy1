<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['video_url', 'video_path', 'lesson_id'];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
