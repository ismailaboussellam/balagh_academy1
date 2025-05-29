<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursVideo extends Model
{
    use HasFactory;

    protected $fillable = ['cours_id', 'description', 'video'];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}
