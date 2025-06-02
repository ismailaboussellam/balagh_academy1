<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filier;
use App\Models\Groupe;

class FilierGroupController extends Controller
{
    // Afficher la page avec filtre
    public function index(Request $request)
    {
        $filiers = Filier::with('groupes')->get();
        $groupesQuery = Groupe::with('filier');
        if ($request->has('filier_filter') && $request->filier_filter) {
            $groupesQuery->where('filier_id', $request->filier_filter);
        }
        $groupes = $groupesQuery->get();
        return view('admin.filiers', compact('filiers', 'groupes'));
    }

    // Ajouter un filier
    public function storeFilier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        Filier::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'تمت إضافة الشعبة بنجاح');
    }

    // Modifier un filier
    public function updateFilier(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $filier = Filier::findOrFail($id);
        $filier->update(['name' => $request->name]);
        return redirect()->back()->with('success', 'تم تعديل الشعبة بنجاح');
    }

    // Supprimer un filier
    public function destroyFilier($id)
    {
        $filier = Filier::findOrFail($id);
        $filier->delete();
        return redirect()->back()->with('success', 'تم حذف الشعبة بنجاح');
    }

    // Ajouter un groupe
    public function storeGroupe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'filier_id' => 'required|exists:filiers,id'
        ]);
        Groupe::create([
            'name' => $request->name,
            'filier_id' => $request->filier_id
        ]);
        return redirect()->back()->with('success', 'تمت إضافة المجموعة بنجاح');
    }

    // Modifier un groupe
    public function updateGroupe(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'filier_id' => 'required|exists:filiers,id'
        ]);
        $groupe = Groupe::findOrFail($id);
        $groupe->update([
            'name' => $request->name,
            'filier_id' => $request->filier_id
        ]);
        return redirect()->back()->with('success', 'تم تعديل المجموعة بنجاح');
    }

    // Supprimer un groupe
    public function destroyGroupe($id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->delete();
        return redirect()->back()->with('success', 'تم حذف المجموعة بنجاح');
    }
}