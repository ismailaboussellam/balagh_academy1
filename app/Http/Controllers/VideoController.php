<?php
namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Lesson; // Assuming videos are related to lessons
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('lesson')->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        $lessons = Lesson::all(); // Get all lessons
        return view('videos.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'video_url' => 'required|url',
        ]);

        Video::create($validated);
        return redirect()->route('videos.index')->with('success', 'Video created successfully!');
    }

    public function show(Video $video)
    {
        return view('videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $lessons = Lesson::all(); // Get all lessons
        return view('videos.edit', compact('video', 'lessons'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'video_url' => 'required|url',
        ]);

        $video->update($validated);
        return redirect()->route('videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video deleted successfully!');
    }
}
