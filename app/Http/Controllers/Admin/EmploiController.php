<?php
// app/Http/Controllers/Admin/EmploiController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emploi;
use App\Models\Groupe;
use App\Models\UserTeacher;

class EmploiController extends Controller
{
    public function index(Request $request)
    {
        $groupes = Groupe::all();
        $selectedGroupe = $request->get('groupe_id', $groupes->first()->id ?? null);
        $semaines = range(1, 52);
        $selectedSemaine = $request->get('semaine', 1);

        $emplois = Emploi::where('groupe_id', $selectedGroupe)
            ->where('semaine', $selectedSemaine)
            ->with('prof')
            ->get();

        // Log des emplois trouvés
        \Log::info('Emplois trouvés:', [
            'groupe_id' => $selectedGroupe,
            'semaine' => $selectedSemaine,
            'count' => $emplois->count(),
            'emplois' => $emplois->toArray()
        ]);

        // فقط الأساتذة المرتبطين بهذا groupe
        $profs = UserTeacher::whereHas('groupes', function($q) use ($selectedGroupe) {
            $q->where('groupes.id', $selectedGroupe);
        })->get();

        // modules و salles static
        $modules = ['M201', 'M202', 'M203', 'M204'];
        $salles = ['A distance', 'SALLE 1', 'SALLE 2', 'SALLE 3', 'SALLE 4', 'SALLE 5'];

        return view('admin.lessons', compact('groupes', 'emplois', 'selectedGroupe', 'profs', 'modules', 'salles', 'semaines', 'selectedSemaine'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'groupe_id' => 'required|exists:groupes,id',
            'prof_id' => 'required|exists:user_teachers,id',
            'module' => 'required',
            'type' => 'required|in:etablissement,distance',
            'salle' => 'required_if:type,etablissement|nullable|string',
            'jour' => 'required',
            'creneau' => 'required',
            'semaine' => 'required|integer|min:1',
        ]);

        // تحويل creneau إلى heure_debut و heure_fin
        [$heure_debut, $heure_fin] = explode('-', $request->creneau);
        
        // إضافة ثواني للتنسيق الموحد
        $heure_debut = trim($heure_debut) . ':00';
        $heure_fin = trim($heure_fin) . ':00';

        // Vérifier conflict
        $conflict = Emploi::where('prof_id', $request->prof_id)
            ->where('jour', $request->jour)
            ->where('semaine', $request->semaine)
            ->where(function($q) use ($heure_debut, $heure_fin) {
                $q->whereBetween('heure_debut', [$heure_debut, $heure_fin])
                  ->orWhereBetween('heure_fin', [$heure_debut, $heure_fin]);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['prof_id' => 'هذا الأستاذ عنده حصة أخرى في هذا الوقت!']);
        }

        Emploi::create([
            'groupe_id' => $request->groupe_id,
            'prof_id' => $request->prof_id,
            'module' => $request->module,
            'type' => $request->type,
            'salle' => $request->type == 'distance' ? 'A distance' : $request->salle,
            'jour' => $request->jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'semaine' => $request->semaine,
        ]);
        return back()->with('success', 'تمت إضافة الحصة بنجاح');
    }

    public function update(Request $request, $id)
    {
        $emploi = Emploi::findOrFail($id);

        $request->validate([
            'prof_id' => 'required|exists:user_teachers,id',
            'module' => 'required',
            'type' => 'required|in:etablissement,distance',
            'salle' => 'nullable|string',
            'jour' => 'required',
            'creneau' => 'required',
            'semaine' => 'required|integer|min:1',
        ]);

        [$heure_debut, $heure_fin] = explode('-', $request->creneau);
        
        // إضافة ثواني للتنسيق الموحد
        $heure_debut = trim($heure_debut) . ':00';
        $heure_fin = trim($heure_fin) . ':00';

        $conflict = Emploi::where('prof_id', $request->prof_id)
            ->where('jour', $request->jour)
            ->where('semaine', $request->semaine)
            ->where('id', '!=', $emploi->id)
            ->where(function($q) use ($heure_debut, $heure_fin) {
                $q->whereBetween('heure_debut', [$heure_debut, $heure_fin])
                  ->orWhereBetween('heure_fin', [$heure_debut, $heure_fin]);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['prof_id' => 'هذا الأستاذ عنده حصة أخرى في هذا الوقت!']);
        }

        $emploi->update([
            'prof_id' => $request->prof_id,
            'module' => $request->module,
            'type' => $request->type,
            'salle' => $request->type == 'distance' ? 'A distance' : $request->salle,
            'jour' => $request->jour,
            'heure_debut' => $heure_debut,
            'heure_fin' => $heure_fin,
            'semaine' => $request->semaine,
        ]);
        return back()->with('success', 'تم تعديل الحصة بنجاح');
    }

    public function destroy($id)
    {
        Emploi::findOrFail($id)->delete();
        return back()->with('success', 'تم حذف الحصة بنجاح');
    }
}