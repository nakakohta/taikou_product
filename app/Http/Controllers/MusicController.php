<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Models\Review;
use App\Models\Comment;

class MusicController extends Controller
{
    public function show($id)
    {
        $music = Music::findOrFail($id);
        $reviews = Review::where('music_id', $id)->get();
        $comments = Comment::with('user')->where('music_id', $id)->get();

        return view('music.show', compact('music', 'reviews', 'comments'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id'  => auth()->id(),  // ← ユーザーから取得
            'music_id' => $id,
            'comment'  => $request->comment,
        ]);

        return redirect()->route('music.show', $id);
    }
}
