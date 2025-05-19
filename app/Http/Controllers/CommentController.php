<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Lesson; // Assuming comments are related to lessons
use App\Models\User; // Assuming comments are made by users
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('lesson', 'user')->get(); // Fetch comments with lessons and users
        return view('comments.index', compact('comments'));
    }

    public function create()
    {
        $lessons = Lesson::all(); // Get all lessons
        return view('comments.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string',
        ]);

        Comment::create($validated);
        return redirect()->route('comments.index')->with('success', 'Comment added successfully!');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        $lessons = Lesson::all(); // Get all lessons
        return view('comments.edit', compact('comment', 'lessons'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'user_id' => 'required|exists:users,id',
            'comment' => 'required|string',
        ]);

        $comment->update($validated);
        return redirect()->route('comments.index')->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully!');
    }
}
