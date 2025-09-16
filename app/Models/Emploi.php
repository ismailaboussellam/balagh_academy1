
دعاء أبوسلام الحراسة و التوثيق في مدينة تطوان سطاج في مركز تطوان تعيين تطوان بنت الدار تعرف على شريك الحياة ولد الناس نقي ز طاهر لم يدخل فلي علاقة من قبل  
تحقيق الأحلام مصممة 
شارع الجيش الملكي 
هناك رجل غني سوف يساعدك في ذلك لأنك فتاة طيبة و تساعد بدون مقابل على الرغم من أنا هاجر و وزوجها و نهيلة يستغلونك بدون مقابل 
أما بالنسبة للجزائري فهو أرد أن يلعب معي 
لهذا سوف أحاول جهدة لكي استقطبه عندك وهو الذي سوف يحقق أحلامك لأنك تستحقي عزيزتي 

لقباق<?php
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