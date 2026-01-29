<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Song;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // My ベストソング（最新3件）
        $bestSongs = Song::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // 好きなジャンル（songs.genre が "JPOP, ロック" 形式想定）
        $genres = Song::where('user_id', $user->id)
            ->pluck('genre')
            ->filter()
            ->flatMap(function ($g) {
                return collect(explode(',', $g))
                    ->map(fn ($x) => trim($x))
                    ->filter();
            })
            ->countBy()
            ->sortDesc();

        $favoriteGenres = $genres->keys()->take(8)->values();

        // ✅ 評価ランキング（平均評価：小数1桁）
        $rankRaw = Song::where('user_id', $user->id)
            ->withAvg('votes', 'rating')
            ->orderByDesc('votes_avg_rating')
            ->take(5)
            ->get();

        $maxRating = (float) ($rankRaw->max('votes_avg_rating') ?? 0);

        $ratingRanking = $rankRaw->map(function ($s) use ($maxRating) {
            $avg = $s->votes_avg_rating ? round((float) $s->votes_avg_rating, 1) : 0.0;
            $pct = $maxRating > 0 ? (int) round(($avg / $maxRating) * 90) : 0;

            return [
                'label' => $s->title,
                'count' => $avg,
                'pct'   => $pct,
            ];
        });

        // ✅ お気に入り数ランキング
        $favRankRaw = Song::where('user_id', $user->id)
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(5)
            ->get();

        $maxFav = (int) ($favRankRaw->max('favorites_count') ?? 0);

        $favoriteRanking = $favRankRaw->map(function ($s) use ($maxFav) {
            $count = (int) $s->favorites_count;
            $pct = $maxFav > 0 ? (int) round(($count / $maxFav) * 90) : 0;

            return [
                'label' => $s->title,
                'count' => $count,
                'pct'   => $pct,
            ];
        });

        // 投稿した曲（編集/削除用）
        $mySongs = Song::where('user_id', $user->id)
            ->latest()
            ->get();

        // ✅ お気に入り一覧（自分がお気に入りした曲）
        $favoriteSongs = Song::whereHas('favorites', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with('user')
            ->latest()
            ->get();

        return view('profile', compact(
            'user',
            'bestSongs',
            'favoriteGenres',
            'ratingRanking',
            'favoriteRanking',
            'mySongs',
            'favoriteSongs'
        ));
    }

    public function updateIcon(Request $request)
    {
        $request->validate([
            'icon' => 'required|image|max:4096',
        ]);

        $file = $request->file('icon');

        // ✅ 本番対策：保存先が無ければ作る
        $dir = public_path('uploads/icons');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $name = uniqid('icon_', true) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        $user = Auth::user();
        $user->icon = 'uploads/icons/' . $name; // asset() で表示OK
        $user->save();

        return back()->with('success', 'アイコンを更新しました！');
    }
}
