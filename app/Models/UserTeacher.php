<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTeacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'birth_date', 'phone', 'address', 'specialization', 'bio'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function filiers() {
        return $this->belongsToMany(Filier::class, 'filier_teacher');
    }

    public function groupes() {
        return $this->belongsToMany(Groupe::class, 'groupe_teacher');
    }
}