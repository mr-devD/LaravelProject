<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'max:100'],
            'description' => 'required'
        ]);

        $comment = Comment::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'task_id' => $request->id,
        ]);

        return back();
    }

    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id);

        $comment->delete();

        return back();
    }
}
