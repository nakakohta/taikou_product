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
        min-width: 0;
    }

    /* =========================
       ✅ ページネーション（ボタンのみ表示）
       - links()のまま
       - Showing/PreviousNextの文字は消す
       - ‹ 1 2 › だけをボタン化
       - 矢印巨大化防止
    ========================= */

    .pager-wrap{
        margin-top: 18px;
        display:flex;
        justify-content:center;
    }

    .pager-wrap nav[aria-label="Pagination Navigation"]{
        width:100%;
        display:flex;
        justify-content:center;
    }

    /* ✅ 上段の「« Previous Next »」(モバイル用)を消す */
    .pager-wrap nav[aria-label="Pagination Navigation"] > div:first-child{
        display:none !important;
    }

    /* ✅ 下段（本来 hidden のやつ）を強制表示して中央寄せ */
    .pager-wrap nav[aria-label="Pagination Navigation"] > div:nth-child(2){
        display:flex !important;
        justify-content:center !important;
        width:100%;
    }

    /* ✅ Showing行（"Showing 1 to..."）を消す */
    .pager-wrap nav[aria-label="Pagination Navigation"] p{
        display:none !important;
    }

    /* ✅ Showing行が入ってる左側ブロック（div）ごと消す */
    .pager-wrap nav[aria-label="Pagination Navigation"] > div:nth-child(2) > div:first-child{
        display:none !important;
    }

    /* ✅ ボタン帯（ページ番号が入ってる側）を中央へ */
    .pager-wrap nav[aria-label="Pagination Navigation"] > div:nth-child(2) > div:last-child{
        width:100%;
        display:flex;
        justify-content:center;
    }

    /* ✅ 矢印(svg)の巨大化防止 */
    .pager-wrap nav[aria-label="Pagination Navigation"] svg{
        width:16px !important;
        height:16px !important;
        max-width:16px !important;
        max-height:16px !important;
        display:block !important;
        flex:0 0 auto !important;
    }

    /* ページボタンの帯 */
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative{
        display:flex !important;
        align-items:center;
        justify-content:center;
        gap:10px;
        flex-wrap:wrap;
        padding: 10px 12px;
        border:2px solid var(--border, #d4e9ff);
        background: rgba(255,255,255,.75);
        border-radius:18px;
        width:fit-content;
        margin:0 auto;
    }

    /* ボタン共通（a / span） */
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative a,
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative span{
        display:inline-flex !important;
        align-items:center !important;
        justify-content:center !important;
        height:40px;
        min-width:40px;
        padding: 0 14px;
        border-radius:14px;
        border:2px solid var(--border, #d4e9ff);
        background:#fff;
        color: var(--text, #0f172a);
        font-weight:900;
        text-decoration:none;
        line-height:1;
        white-space:nowrap;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        transition: transform .05s ease, border-color .15s ease, background .15s ease, color .15s ease;
    }

    /* hover */
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative a:hover{
        border-color: var(--text-blue, #3b82f6);
        color: var(--text-blue, #3b82f6);
        background: rgba(59,130,246,.06);
        transform: translateY(-1px);
    }

    /* 現在ページ（aria-current="page"） */
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative span[aria-current="page"]{
        background: var(--text-blue, #3b82f6);
        color:#fff;
        border-color: var(--text-blue, #3b82f6);
        box-shadow: 0 10px 22px rgba(59,130,246,.22);
    }

    /* 無効（先頭/末尾の矢印） */
    .pager-wrap nav[aria-label="Pagination Navigation"] span.relative span[aria-disabled="true"]{
        opacity:.35 !important;
        cursor:not-allowed !important;
        box-shadow:none !important;
        transform:none !important;
    }

    @media (max-width:520px){
        .pager-wrap nav[aria-label="Pagination Navigation"] span.relative{
            gap:8px;
            padding:10px;
            border-radius:16px;
        }
        .pager-wrap nav[aria-label="Pagination Navigation"] span.relative a,
        .pager-wrap nav[aria-label="Pagination Navigation"] span.relative span{
            height:42px;
            min-width:42px;
            border-radius:14px;
        }
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
                <div class="genre-tag">{{ $song->genre ?? '未設定' }}</div>

                {{-- ✅ 平均評価表示（そのまま） --}}
                @if(isset($song->avg_rating))
                    <div style="margin-top:6px; font-weight:800; opacity:.85;">
                        平均：{{ number_format((float)$song->avg_rating, 2) }}
                    </div>
                @endif
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

{{-- ✅ ページネーション（links()のまま） --}}
@if(isset($recentSongs) && method_exists($recentSongs, 'links'))
    <div class="pager-wrap">
        {{ $recentSongs->links() }}
    </div>
@endif

@endsection
