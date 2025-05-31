<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\CoursFichier;
use App\Models\CoursVideo;

class CoursFrontController extends Controller
{
    // Afficher la liste des cours
    public function index()
    {
        $cours = Cours::all();
        return view('pages.cours', compact('cours'));
    }

    // Détails d'un cours (pour la modale AJAX)
    public function details($id)
    {
        $cours = Cours::findOrFail($id);
        return response()->json([
            'id' => $cours->id,
            'name' => $cours->name,
            'description' => $cours->description,
            'presentation' => $cours->presentation,
            'type' => $cours->type,
            'image' => $cours->image ? asset('storage/' . $cours->image) : null,
        ]);
    }

    // Page de lecture du cours (après paiement ou si gratuit)
    public function learn($id)
    {
        $cours = Cours::findOrFail($id);
        $videos = CoursVideo::where('cours_id', $id)->get();
        $fichiers = CoursFichier::where('cours_id', $id)->get();
        return view('pages.cours_detaile', compact('cours', 'videos', 'fichiers'));
    }

    // Paiement (simulation)
    public function payment(Request $request, $id)
    {
        // Ici tu peux ajouter la logique de paiement réelle
        // Pour l'instant, on simule que le paiement est toujours OK
        // Tu peux sauvegarder les infos de l'utilisateur si tu veux

        // Redirige vers la page de lecture du cours
        return response()->json(['success' => true, 'redirect' => route('cours.learn', $id)]);
    }
}