@extends('layouts.app')

@section('content')

<style>
    .btn-post {
        display: inline-block;
        padding: 14px 34px;
        background: var(--text-blue);
        border-radius: 28px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        margin-bottom: 22px;
    }

    .section-title {
        font-size: 22px;
        font-weight: bold;
        color: var(--text-blue);
        margin: 26px 0 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ranking-card {
        background: var(--card);
        border: 2px solid var(--border);
        border-radius: 16px;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }

    .rank-badge {
        width: 46px;
        height: 46px;
        background: #60a5fa;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        flex: 0 0 auto;
    }

    .song-info {
        flex: 1;
        min-width: 0;
    }

    .song-title {
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .genre-tag {
        display: inline-block;
        background: var(--border);
        padding: 4px 10px;
        border-radius: 10px;
        font-size: 12px;
        margin-top: 6px;
    }

    .song-link {
        display: inline-block;
        margin-top: 6px;
        color: var(--text-blue);
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        white-space: nowrap;
    }

    .song-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 18px;
    }

    .song-card {
        background: var(--card);
        border: 2px solid var(--border);
        padding: 14px;
        border-radius: 14px;
    }
</style>

<a href="{{ route('songs.create') }}" class="btn-post">＋ 曲を投稿する</a>

{{-- ✅ 今日のランキング --}}
<h2 class="section-title">🏆 今日のランキング TOP5</h2>

@if(isset($dailyRanking) && $dailyRanking->isNotEmpty())
    @foreach ($dailyRanking as $index => $song)
        <div class="ranking-card">
            <div class="rank-badge">{{ $index + 1 }}</div>

            <div class="song-info">
                <div class="song-title">{{ $song->title }}</div>
                <div>by {{ $song->artist }}</div>

                {{-- genre は「文字列」運用ならこちら --}}
                <div class="genre-tag">{{ $song->genre ?? '未設定' }}</div>

                {{-- genre_id（genresテーブル）運用ならこちらに切り替え
                <div class="genre-tag">{{ optional($song->genre)->name ?? '未設定' }}</div>
                --}}
            </div>

            <a href="{{ route('music.show', $song->id) }}" class="song-link">▶ 曲ページへ</a>
        </div>
    @endforeach
@else
    <div style="opacity:.7; margin: 8px 0 18px;">
        まだ投票がないのでランキングは準備中です。
    </div>
@endif

{{-- ✅ 最近投稿 --}}
<h2 class="section-title">🎧 最近投稿された曲</h2>

<div class="song-list">
    @forelse ($recentSongs ?? collect() as $song)
        <div class="song-card">
            <span class="genre-tag">{{ $song->genre ?? '未設定' }}</span>

            <div class="song-title">{{ $song->title }}</div>
            <div>by {{ $song->artist }}</div>

            <a href="{{ route('music.show', $song->id) }}" class="song-link">▶ 曲ページへ</a>
        </div>
    @empty
        <p>まだ投稿がありません。</p>
    @endforelse
</div>

@endsection
