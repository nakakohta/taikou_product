<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
    // 曲ページ表示
    public function show($id)
    {
        $song = Song::with(['user'])->findOrFail($id);

        $comments = Comment::with('user')
            ->where('song_id', $song->id)
            ->orderByDesc('created_at')
            ->get();

        $avgRating = (int) round(
            Vote::where('song_id', $song->id)->avg('rating') ?? 0
        );

        $myRating = null;
        if (Auth::check()) {
            $myRating = Vote::where('song_id', $song->id)
                ->where('user_id', Auth::id())
                ->value('rating');
        }

        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Favorite::where('song_id', $song->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        $thumbnailUrl = $this->makeThumbnailUrl($song);

        return view('music.show', compact(
            'song',
            'comments',
            'avgRating',
            'myRating',
            'isFavorited',
            'thumbnailUrl'
        ));
    }

    // コメント投稿
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        Comment::create([
            'song_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back();
    }

    // ★評価
    public function storeVote(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Vote::updateOrCreate(
            ['song_id' => $id, 'user_id' => Auth::id()],
            ['rating' => $request->rating]
        );

        return back();
    }

    // お気に入り ON/OFF（トグル）
    public function toggleFavorite($id)
    {
        $exists = Favorite::where('song_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            Favorite::where('song_id', $id)
                ->where('user_id', Auth::id())
                ->delete();
        } else {
            Favorite::create([
                'song_id' => $id,
                'user_id' => Auth::id(),
            ]);
        }

        return back();
    }

    private function makeThumbnailUrl(Song $song): ?string
    {
        if (!empty($song->thumbnail)) {
            return asset('storage/' . $song->thumbnail);
        }

        $url = $song->url ?? '';
        $videoId = $this->extractYouTubeId($url);
        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    private function extractYouTubeId(string $url): ?string
    {
        if (preg_match('~youtu\.be/([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];
        if (preg_match('~v=([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];
        if (preg_match('~/embed/([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];
        return null;
    }
}
