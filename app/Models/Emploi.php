<?php
// app/Models/Emploi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emploi extends Model
{
    protected $fillable = [
        'groupe_id', 'prof_id', 'module', 'salle', 'type', 'jour', 'heure_debut', 'heure_fin', 'semaine'
    ];

    public function groupe() {
        return $this->belongsTo(Groupe::class);
    }

    public function prof() {
        return $this->belongsTo(UserTeacher::class, 'prof_id');
    }
}
