<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // ②に続く…
        $today = Carbon::today();

    // 今日の5つ星ランキング
    $dailyRanking = Song::with('genre')
        ->withAvg(['votes as avg_rating' => function ($q) use ($today) {
            $q->whereDate('created_at', $today);
        }], 'rating')
        ->withCount(['votes as today_vote_count' => function ($q) use ($today) {
            $q->whereDate('created_at', $today);
        }])
        ->orderByDesc('avg_rating')
        ->orderByDesc('today_vote_count')
        ->limit(10)
        ->get();

    // 最近投稿された曲
    $recentSongs = Song::with('genre')
        ->latest()
        ->limit(10)
        ->get();

    // ★ ここでビューに渡す
    return view('home', compact('dailyRanking', 'recentSongs'));
    }
}


