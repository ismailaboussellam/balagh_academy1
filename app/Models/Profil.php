<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profil extends Model
{
    protected $fillable = [
        'user_id',
        'profile_photo',
        'biography',
        // ... أي أعمدة أخرى
    ];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor لجلب الصورة أو الحروف الأولى
    public function getAvatarAttribute()
    {
        if ($this->profile_photo && Storage::disk('public')->exists($this->profile_photo)) {
            return asset('storage/' . $this->profile_photo);
        }
        // إذا لم توجد صورة، يرجع الحرف الأول من الاسم واللقب
        $first = $this->user->first_name ? mb_substr($this->user->first_name, 0, 1) : '';
        $last = $this->user->last_name ? mb_substr($this->user->last_name, 0, 1) : '';
        return strtoupper($first . $last);
    }
}
