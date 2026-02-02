<?php

namespace App\Http\Controllers;

use App\Models\Song;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ ランキング：サイト全体 TOP5（平均評価が高い順）
        // 票がない曲は avg_rating が null になるので、最後に回したい場合は orderByRaw を使う
        $dailyRanking = Song::query()
            ->select('songs.*')
            ->selectSub(function ($q) {
                $q->from('votes')
                    ->whereColumn('votes.song_id', 'songs.id')
                    ->selectRaw('AVG(rating)');
            }, 'avg_rating')
            ->selectSub(function ($q) {
                $q->from('votes')
                    ->whereColumn('votes.song_id', 'songs.id')
                    ->selectRaw('COUNT(*)');
            }, 'vote_count')
            // ✅ 平均評価の高い順（NULLは最後へ）
            ->orderByRaw('avg_rating IS NULL')   // NULLを後ろに
            ->orderByDesc('avg_rating')          // 平均評価 降順
            ->orderByDesc('vote_count')          // 同率なら票数が多い方
            ->limit(5)
            ->get();

        // ✅ 最近投稿：ページネーションは変更しない（12件/ページ）
        $recentSongs = Song::latest()->paginate(12);

        return view('home', compact('dailyRanking', 'recentSongs'));
    }
}
