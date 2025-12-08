<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function create()
    {
        return view('songs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:500',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genres' => 'required|array',
            'comment' => 'required|string|max:1000',
        ]);

        $selectedGenres = $request->genres;
        if (in_array('その他', $selectedGenres) && $request->filled('genre_other_text')) {
            $selectedGenres = array_diff($selectedGenres, ['その他']);
            $selectedGenres[] = $request->genre_other_text;
        }

        Song::create([
            'user_id' => Auth::id(),
            'genre_id' => 1,
            'url' => $request->url,
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => implode(', ', $selectedGenres),
            'comment' => $request->comment,
        ]);

        return redirect()->route('songs.create')->with('success', '曲を投稿しました！');
    }
}

