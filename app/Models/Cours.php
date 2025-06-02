<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'presentation' , 'type', 'image', 'price'];

    public function fichiers()
    {
        return $this->hasMany(CoursFichier::class);
    }

    public function videos()
    {
        return $this->hasMany(CoursVideo::class);
    }
}
