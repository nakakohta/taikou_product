<?php

namespace App\Http\Controllers;

use App\Models\Song;

class HomeController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $dailyRanking = Song::select('songs.*')
            ->selectSub(function ($q) use ($today) {
                $q->from('votes')
                    ->whereColumn('votes.song_id', 'songs.id')
                    ->whereDate('created_at', $today)
                    ->selectRaw('AVG(rating)');
            }, 'avg_rating')
            ->selectSub(function ($q) use ($today) {
                $q->from('votes')
                    ->whereColumn('votes.song_id', 'songs.id')
                    ->whereDate('created_at', $today)
                    ->selectRaw('COUNT(*)');
            }, 'today_vote_count')
            ->orderByDesc('avg_rating')
            ->orderByDesc('today_vote_count')
            ->limit(5)
            ->get();

        // ✅ 12件以上でも古い投稿が見れる（ページング）
        $recentSongs = Song::latest()->paginate(12);

        return view('home', compact('dailyRanking', 'recentSongs'));
    }
}
