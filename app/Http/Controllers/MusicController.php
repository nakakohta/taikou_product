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
        $comments = Comment::where('music_id', $id)->get();

        return view('music.show', compact('music', 'reviews', 'comments'));
    }
}
