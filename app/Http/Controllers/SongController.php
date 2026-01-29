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

    private function isYoutubeUrl(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);
        $host = strtolower(preg_replace('/^www\./', '', (string)$host));

        return $host === 'youtube.com'
            || str_ends_with($host, '.youtube.com')
            || $host === 'youtu.be';
    }

    private function extractYoutubeId(string $url): ?string
    {
        $parts = parse_url($url);
        if (!$parts) return null;

        $host = strtolower(preg_replace('/^www\./', '', (string)($parts['host'] ?? '')));
        $path = (string)($parts['path'] ?? '');
        $query= (string)($parts['query'] ?? '');

        // youtu.be/VIDEOID
        if ($host === 'youtu.be') {
            $seg = array_values(array_filter(explode('/', $path)));
            return $seg[0] ?? null;
        }

        // watch?v=VIDEOID
        parse_str($query, $q);
        if (!empty($q['v'])) return (string)$q['v'];

        // /shorts/VIDEOID or /embed/VIDEOID
        $seg = array_values(array_filter(explode('/', $path)));
        $idx = array_search('shorts', $seg, true);
        if ($idx !== false && !empty($seg[$idx + 1])) return $seg[$idx + 1];

        $idx = array_search('embed', $seg, true);
        if ($idx !== false && !empty($seg[$idx + 1])) return $seg[$idx + 1];

        return null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url'     => ['required', 'string', 'max:2048'],
            'title'   => ['required', 'string', 'max:255'],
            'artist'  => ['required', 'string', 'max:255'],
            'genre'   => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:500'],
        ], [
            'genre.required' => 'ジャンルを1つ以上選択してください。',
        ]);

        // ✅ YouTubeのみ許可（サーバ側）
        if (!$this->isYoutubeUrl($validated['url'])) {
            return back()->withErrors(['url' => 'YouTube（youtube.com / youtu.be）のURLのみ投稿できます。'])->withInput();
        }

        // ✅ IDが取れないYouTube URLも弾く
        if (!$this->extractYoutubeId($validated['url'])) {
            return back()->withErrors(['url' => 'YouTube動画IDを含むURLを入力してください。'])->withInput();
        }

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

        // ✅ YouTubeのみ許可（サーバ側）
        if (!$this->isYoutubeUrl($validated['url'])) {
            return back()->withErrors(['url' => 'YouTube（youtube.com / youtu.be）のURLのみ投稿できます。'])->withInput();
        }

        if (!$this->extractYoutubeId($validated['url'])) {
            return back()->withErrors(['url' => 'YouTube動画IDを含むURLを入力してください。'])->withInput();
        }

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
