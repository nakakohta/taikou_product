@extends('layouts.app')

@section('content')

<style>
/* ============================
   曲ページデザイン（ライト / ダーク対応）
============================ */

.music-container {
    max-width: 1100px;
    margin: 30px auto;
    background: var(--card-bg);
    padding: 30px;
    border-radius: 20px;
    border: 2px solid var(--border);
    box-shadow: 0 6px 18px var(--shadow);
}

/* 上部レイアウト */
.music-top {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.thumbnail {
    width: 280px;
    height: 280px;
    background: #eef6ff;
    border-radius: 16px;
    border: 2px solid var(--border);
    overflow: hidden;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.music-info {
    flex: 1;
}

.music-title {
    font-size: 28px;
    font-weight: bold;
    color: var(--text-blue);
    margin-bottom: 15px;
}

.music-desc {
    background: var(--bg);
    padding: 15px;
    border-radius: 12px;
    border: 2px solid var(--border);
    margin-bottom: 20px;
}

/* レビュー表示 */
.stars {
    font-size: 28px;
    color: #fbbf24;
}

.review-count {
    color: var(--text);
    margin-top: 6px;
}

/* 区切り線 */
.line {
    border-top: 2px solid var(--border);
    margin: 30px 0;
}

/* コメント一覧 */
.comment-title {
    font-size: 22px;
    font-weight: bold;
    color: var(--text-blue);
    margin-bottom: 15px;
}

.comment-box {
    border: 2px solid var(--border);
    background: var(--card-bg);
    padding: 15px;
    border-radius: 14px;
    margin-bottom: 18px;
}

.comment-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 6px;
}

.comment-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border);
}

.comment-name {
    font-weight: bold;
    font-size: 15px;
}

.comment-text {
    font-size: 15px;
    color: var(--text);
}

/* スマホ対応 */
@media (max-width: 768px) {
    .music-top {
        flex-direction: column;
        align-items: center;
    }
    .thumbnail {
        width: 90%;
        max-width: 320px;
        height: auto;
    }
}
</style>


<div class="music-container">

    <!-- 上部：サムネ＋情報 -->
    <div class="music-top">

        <div class="thumbnail">
            <img src="{{ asset('storage/' . $music->thumbnail) }}" alt="サムネ">
        </div>

        <div class="music-info">
            <div class="music-title">{{ $music->title }}</div>

            <div class="music-desc">
                {{ $music->description }}
            </div>

            @php $avg = $reviews->avg('rating') ?? 0; @endphp

            <div class="stars">
                @for($i=1; $i<=5; $i++)
                    @if($i <= $avg)
                        ★
                    @else
                        <span style="color:#94a3b8;">★</span>
                    @endif
                @endfor
            </div>

            <div class="review-count">
                レビュー {{ $reviews->count() }}件
            </div>
        </div>
    </div>

    <div class="line"></div>

    <!-- コメント一覧 -->
    <div class="comment-title">コメント一覧</div>

    @foreach ($comments as $comment)
        <div class="comment-box">

            <div class="comment-header">
                @if ($comment->user && $comment->user->icon)
                    <img src="{{ asset('storage/' . $comment->user->icon) }}" class="comment-icon">
                @else
                    <img src="{{ asset('images/default_icon.png') }}" class="comment-icon">
                @endif

                <div class="comment-name">
                    {{ $comment->user->name ?? '名無し' }}
                </div>
            </div>

            <div class="comment-text">
                {{ $comment->comment }}
            </div>
        </div>
    @endforeach

</div>

@endsection
