<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'phone_code',
        'profile_image',
        'gender',
        'birth_day',
        'birth_month',
        'birth_year',
        'user_type',
        'nationality',
        'profile_picture',
        'residence_country',
        'domain',
        'fi2a',
        'password',
    ];



  public function lessonsAsStudent()
{
    return $this->hasMany(Lesson::class, 'student_id');
}

public function lessonsAsTeacher()
{
    return $this->hasMany(Lesson::class, 'teacher_id');
}

public function exams()
{
    return $this->hasMany(Evaluation::class, 'student_id');
}


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
