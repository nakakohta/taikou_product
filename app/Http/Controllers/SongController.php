<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function create()
    {
        $genres = Genre::orderBy('sort_order')->orderBy('name')->get();
        return view('songs.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url'     => ['required', 'string', 'max:2048'],
            'title'   => ['required', 'string', 'max:255'],
            'artist'  => ['required', 'string', 'max:255'],
            'genre'   => ['required', 'string', 'max:255'], // 複数なら "A, B"
            'comment' => ['nullable', 'string', 'max:500'],
        ], [
            'genre.required' => 'ジャンルを1つ以上選択してください。',
        ]);

        Song::create([
            'user_id'  => Auth::id(),
            'url'      => $validated['url'],
            'title'    => $validated['title'],
            'artist'   => $validated['artist'],
            'genre'    => $validated['genre'],
            'comment'  => $validated['comment'] ?? '',
        ]);

        return redirect()->route('profile')->with('success', '投稿しました！');
    }

    public function edit($id)
    {
        $song = Song::where('user_id', Auth::id())->findOrFail($id);
        $genres = Genre::orderBy('sort_order')->orderBy('name')->get();

        return view('songs.edit', compact('song', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $song = Song::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'url'     => ['required', 'string', 'max:2048'],
            'title'   => ['required', 'string', 'max:255'],
            'artist'  => ['required', 'string', 'max:255'],
            'genre'   => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:500'],
        ], [
            'genre.required' => 'ジャンルを1つ以上選択してください。',
        ]);

        $song->update([
            'url'     => $validated['url'],
            'title'   => $validated['title'],
            'artist'  => $validated['artist'],
            'genre'   => $validated['genre'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return redirect()->route('profile')->with('success', '更新しました！');
    }

    public function destroy($id)
    {
        $song = Song::where('user_id', Auth::id())->findOrFail($id);
        $song->delete();

        return redirect()->route('profile')->with('success', '削除しました！');
    }
}
