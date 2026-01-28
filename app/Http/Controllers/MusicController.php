<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Comment;
use App\Models\Vote;

class MusicController extends Controller
{
    // 曲詳細ページ
    public function show($id)
    {
        $song = Song::with('user')->findOrFail($id);

        // コメント一覧（新しい順）
        $comments = Comment::with('user')
            ->where('song_id', $song->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 平均評価・件数
        $avgRating = Vote::where('song_id', $song->id)->avg('rating');
        $avgRating = $avgRating ? round($avgRating, 1) : null;
        $ratingCount = Vote::where('song_id', $song->id)->count();

        // 自分の評価
        $myRating = null;
        if (auth()->check()) {
            $myRating = Vote::where('song_id', $song->id)
                ->where('user_id', auth()->id())
                ->value('rating');
        }

        return view('music.show', compact(
            'song',
            'comments',
            'avgRating',
            'ratingCount',
            'myRating'
        ));
    }

    // コメント投稿
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $song = Song::findOrFail($id);

        Comment::create([
            'song_id' => $song->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return redirect()->route('music.show', $song->id)->with('success', 'コメントしました！');
    }

    // ★評価（投票）
    public function storeVote(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $song = Song::findOrFail($id);

        // 既に評価していたら更新、なければ作成
        Vote::updateOrCreate(
            [
                'song_id' => $song->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
            ]
        );

        return redirect()->route('music.show', $song->id)->with('success', '評価を保存しました！');
    }
}
