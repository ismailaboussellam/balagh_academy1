<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\CoursFichier;
use App\Models\CoursVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::latest()->get();
        return view('admin.cours', compact('cours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'presentation' => 'nullable|string',
            'type' => 'required|in:gratuit,payant',
            'price' => 'required_if:type,payant|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        // Si le cours est gratuit, définir le prix à 0
        if ($validated['type'] === 'gratuit') {
            $validated['price'] = 0;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cours', 'public');
        } else {
            $validated['image'] = 'cours/default.jpg'; // Assurez-vous que cette image existe
        }

        Cours::create($validated);

        return redirect()->route('admin.cours.index')->with('success', 'تم إضافة الدرس بنجاح');
    }

    public function show(Cours $cours)
    {
        return view('admin.cours_details', compact('cours'));
    }

    public function edit(Cours $cours)
    {
        return response()->json($cours);
    }

    public function update(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'presentation' => 'nullable|string',
            'type' => 'required|in:gratuit,payant',
            'price' => 'required_if:type,payant|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        // Si le cours est gratuit, définir le prix à 0
        if ($validated['type'] === 'gratuit') {
            $validated['price'] = 0;
        }

        if ($request->hasFile('image')) {
            if ($cours->image && $cours->image != 'cours/default.jpg') {
                Storage::disk('public')->delete($cours->image);
            }
            $validated['image'] = $request->file('image')->store('cours', 'public');
        } else if (!$cours->image) {
            $validated['image'] = 'cours/default.jpg'; // Assurez-vous que cette image existe
        }

        $cours->update($validated);

        return redirect()->back()->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy(Cours $cours)
    {
        // Supprimer les fichiers associés
        foreach ($cours->fichiers as $fichier) {
            if ($fichier->fichier) {
                Storage::disk('public')->delete($fichier->fichier);
            }
            $fichier->delete();
        }

        // Supprimer les vidéos associées
        foreach ($cours->videos as $video) {
            if ($video->video && !Str::contains($video->video, ['youtube.com', 'youtu.be'])) {
                Storage::disk('public')->delete($video->video);
            }
            $video->delete();
        }

        // Supprimer l'image du cours
        if ($cours->image && $cours->image != 'cours/default.jpg') {
            Storage::disk('public')->delete($cours->image);
        }

        $cours->delete();

        return response()->json(['success' => true]);
    }

    public function storeFichier(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'fichier' => 'required|file|max:10240' // 10MB max
        ]);

        $path = $request->file('fichier')->store('cours_fichiers', 'public');

        $fichier = new CoursFichier([
            'cours_id' => $cours->id,
            'description' => $validated['description'],
            'fichier' => $path
        ]);

        $fichier->save();

        return redirect()->back()->with('success', 'تم إضافة الملف بنجاح');
    }

    public function destroyFichier(CoursFichier $fichier)
    {
        if ($fichier->fichier) {
            Storage::disk('public')->delete($fichier->fichier);
        }

        $fichier->delete();

        return response()->json(['success' => true]);
    }

    public function storeVideo(Request $request, Cours $cours)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'video_type' => 'required|in:file,youtube',
            'video_file' => 'required_if:video_type,file|file|mimes:mp4,mov,avi,wmv|max:102400', // 100MB max
            'video_url' => 'required_if:video_type,youtube|url'
        ]);

        $video = new CoursVideo([
            'cours_id' => $cours->id,
            'description' => $request->description
        ]);

        if ($request->video_type === 'file') {
            $path = $request->file('video_file')->store('cours_videos', 'public');
            $video->video = $path;
        } else {
            $video->video = $request->video_url;
        }

        $video->save();

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح');
    }

    public function destroyVideo(CoursVideo $video)
    {
        if ($video->video && !Str::contains($video->video, ['youtube.com', 'youtu.be'])) {
            Storage::disk('public')->delete($video->video);
        }

        $video->delete();

        return response()->json(['success' => true]);
    }
}