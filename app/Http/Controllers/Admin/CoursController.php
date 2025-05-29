<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\CoursFichier;
use App\Models\CoursVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cours', 'public');
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
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($cours->image) {
                Storage::disk('public')->delete($cours->image);
            }
            $validated['image'] = $request->file('image')->store('cours', 'public');
        }

        $cours->update($validated);

        return redirect()->back()->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy(Cours $cours)
    {
        if ($cours->image) {
            Storage::disk('public')->delete($cours->image);
        }
        
        // Delete associated files and videos
        foreach ($cours->fichiers as $fichier) {
            Storage::disk('public')->delete($fichier->fichier);
        }
        foreach ($cours->videos as $video) {
            if (!str_contains($video->video, ['youtube.com', 'youtu.be'])) {
                Storage::disk('public')->delete($video->video);
            }
        }
        
        $cours->delete();
        
        return response()->json(['success' => true]);
    }

    public function storeFichier(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'fichier' => 'required|file|max:10240'
        ]);

        $validated['fichier'] = $request->file('fichier')->store('cours/fichiers', 'public');
        $cours->fichiers()->create($validated);

        return redirect()->back()->with('success', 'تم إضافة الملف بنجاح');
    }

    public function destroyFichier(CoursFichier $fichier)
    {
        Storage::disk('public')->delete($fichier->fichier);
        $fichier->delete();
        
        return response()->json(['success' => true]);
    }

    public function storeVideo(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'video_type' => 'required|in:file,youtube',
            'video_file' => 'required_if:video_type,file|file|mimes:mp4,mov,avi|max:102400',
            'video_url' => 'required_if:video_type,youtube|url'
        ]);

        if ($request->video_type === 'file') {
            $video = $request->file('video_file')->store('cours/videos', 'public');
        } else {
            $video = $request->video_url;
        }

        $cours->videos()->create([
            'description' => $validated['description'],
            'video' => $video
        ]);

        return redirect()->back()->with('success', 'تم إضافة الفيديو بنجاح');
    }

    public function destroyVideo(CoursVideo $video)
    {
        if (!str_contains($video->video, ['youtube.com', 'youtu.be'])) {
            Storage::disk('public')->delete($video->video);
        }
        $video->delete();
        
        return response()->json(['success' => true]);
    }
}