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

        // ✅ My ベストソング（最新3件）
        $bestSongs = Song::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // ✅ 好きなジャンル（自分の投稿曲のgenreを集計：カンマ区切り対応）
        $genresCount = Song::where('user_id', $user->id)
            ->pluck('genre')
            ->filter()
            ->flatMap(function ($g) {
                return collect(explode(',', $g))
                    ->map(fn ($x) => trim($x))
                    ->filter();
            })
            ->countBy()
            ->sortDesc();

        $favoriteGenres = $genresCount->keys()->take(8)->values();

        // ✅ 投稿した曲（編集・削除用の一覧）
        $mySongs = Song::where('user_id', $user->id)
            ->latest()
            ->get();

        // ✅ お気に入り数ランキング（自分の投稿曲が「何回」お気に入りされたか）
        $rankingSongs = Song::where('user_id', $user->id)
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $max = (int) ($rankingSongs->max('favorites_count') ?? 0);

        $favoriteRanking = $rankingSongs->map(function ($song) use ($max) {
            $count = (int) $song->favorites_count;
            $pct = $max > 0 ? (int) round(($count / $max) * 90) : 0;
            return [
                'label' => $song->title,
                'count' => $count,
                'pct'   => $pct,
            ];
        });

        // ✅ 追加：お気に入り一覧（自分がお気に入り登録した曲）
        // favoritesテーブル経由で、song情報を取る
        $favoriteSongs = $user->favorites()
            ->with(['song.user'])           // Favorite -> Song -> User
            ->latest()
            ->get()
            ->map(function ($fav) {
                return $fav->song;
            })
            ->filter(); // songが消えていた場合に備える

        return view('profile', compact(
            'user',
            'bestSongs',
            'favoriteGenres',
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

        $path = $request->file('icon')->store('icons', 'public');

        $user = Auth::user();
        $user->icon = $path;
        $user->save();

        return back()->with('success', 'アイコンを更新しました！');
    }
}
