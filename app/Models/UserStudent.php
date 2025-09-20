<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStudent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_code',
        'phone',
        'gender',
        'birth_day',
        'birth_month',
        'birth_year',
        'nationality',
        'residence_country',
        'domain',
        'fi2a',
        'password',
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function filiers() {
        return $this->belongsToMany(Filier::class, 'filier_student', 'student_id', 'filier_id');
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class, 'groupe_student', 'student_id', 'groupe_id');
    }
}
