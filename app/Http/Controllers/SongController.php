<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ログイン必須
    }

    // ✅ 投稿フォーム表示（genres を渡す）
    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('songs.create', compact('genres'));
    }

    // ✅ 投稿保存（複数ジャンル → name をカンマ保存）
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|max:500',
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'integer|exists:genres,id',
            'comment' => 'nullable|string',
        ]);

        $genreNames = [];
        if ($request->filled('genre_ids')) {
            $genreNames = Genre::whereIn('id', $request->genre_ids)->pluck('name')->toArray();
        }

        Song::create([
            'user_id' => auth()->id(),
            'url' => $request->url,
            'title' => $request->title,
            'artist' => $request->artist,
            'genre' => implode(',', $genreNames),
            'comment' => $request->comment ?? '',
        ]);

        return redirect()->route('home')->with('success', '投稿しました！');
    }
}
