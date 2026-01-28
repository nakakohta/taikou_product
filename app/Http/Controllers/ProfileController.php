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

        // ✅ My ベストソング（例：最新3件）
        $bestSongs = Song::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        // ✅ 好きなジャンル（songs.genre は "JPOP, ロック" みたいなカンマ区切り想定）
        $genres = Song::where('user_id', $user->id)
            ->pluck('genre')
            ->filter()
            ->flatMap(function ($g) {
                return collect(explode(',', $g))->map(fn($x) => trim($x))->filter();
            })
            ->countBy()
            ->sortDesc();

        $favoriteGenres = $genres->keys()->take(8)->values(); // 上位8

        // ✅ 好きな曲の集計（例：自分が投稿した曲の title ごとの件数Top4）
        $statsRaw = Song::where('user_id', $user->id)
            ->selectRaw('title, COUNT(*) as cnt')
            ->groupBy('title')
            ->orderByDesc('cnt')
            ->take(4)
            ->get();

        $max = (int) ($statsRaw->max('cnt') ?? 0);

        $songStats = $statsRaw->map(function ($row) use ($max) {
            $pct = $max > 0 ? (int) round(($row->cnt / $max) * 90) : 0; // 見た目用（最大90%）
            return [
                'label' => $row->title,
                'count' => (int) $row->cnt,
                'pct'   => $pct,
            ];
        });

        return view('profile', compact('user', 'bestSongs', 'favoriteGenres', 'songStats'));
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
