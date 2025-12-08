<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Genre;

class SongController extends Controller
{
    /**
     * 曲投稿フォーム表示
     */
    public function create()
    {
        $genres = Genre::all();
        return view('songs.create', compact('genres'));
    }

    /**
     * 曲保存処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'artist'    => 'required|string|max:255',
            'genre_id'  => 'required|integer',
            'url'       => 'required|string|max:500',
            'comment'   => 'nullable|string',
            'thumbnail' => 'nullable|image|max:4096',
        ]);

        // サムネイル画像保存
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // 保存処理
        Song::create([
            'title'     => $request->title,
            'artist'    => $request->artist,
            'genre_id'  => $request->genre_id,
            'url'       => $request->url,
            'comment'   => $request->comment,
            'thumbnail' => $thumbnailPath,
            'user_id'   => auth()->id() ?? 0,
        ]);

        return redirect()->route('home')->with('success', '曲を投稿しました！');
    }
}
