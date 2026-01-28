@extends('layouts.app')

@section('content')
<style>
*, *::before, *::after { box-sizing:border-box; }

.wrap{ max-width: 920px; margin: 28px auto; padding: 0 16px; }
.card{
  background:#fff;
  border:2px solid #cfe5ff;
  border-radius:22px;
  padding:18px;
  box-shadow:0 12px 30px rgba(0,0,0,.06);
  margin-bottom:16px;
}
.h1{ font-size:22px; font-weight:900; color:#2563eb; margin:0 0 6px; }
.muted{ color:#64748b; font-size:13px; }

.row{ display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap; }
.thumb{
  width:220px; max-width:100%;
  aspect-ratio: 16/9;
  border-radius:16px;
  overflow:hidden;
  border:2px solid #cfe5ff;
  background:#f5faff;
}
.thumb iframe{ width:100%; height:100%; border:0; display:block; }
.meta{ flex: 1; min-width: 240px; }
.badge{
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 12px; border-radius:999px;
  border:2px solid #cfe5ff; background:#f5faff;
  font-weight:900; font-size:13px; color:#0f172a;
}

.section-title{ font-weight:900; color:#2563eb; margin:0 0 10px; }

.rating-wrap{ display:flex; gap:10px; flex-wrap:wrap; }
.rating-wrap input[type="radio"]{ position:absolute; opacity:0; pointer-events:none; }
.rate-btn{
  display:inline-flex; align-items:center; justify-content:center;
  min-width:72px; padding:10px 14px;
  border-radius:999px;
  border:2px solid #cfe5ff;
  background:#f5faff;
  font-weight:900;
  cursor:pointer;
  user-select:none;
}
.rating-wrap input[type="radio"]:checked + .rate-btn{
  border-color:#2563eb;
  background:rgba(37,99,235,.12);
  color:#2563eb;
}

.input, .textarea{
  width:100%; max-width:100%;
  padding:12px 14px;
  border-radius:14px;
  border:2px solid #cfe5ff;
  background:#f5faff;
  font-size:14px;
}
.textarea{ min-height:110px; resize:vertical; }

.btn{
  width:100%;
  margin-top:10px;
  padding:12px 0;
  border:none;
  border-radius:999px;
  font-weight:900;
  color:#fff;
  background:#2563eb;
  cursor:pointer;
}
.btn:hover{ opacity:.95; }

.success{
  background:#e7f7ff; border:2px solid #bfe8ff; color:#0369a1;
  border-radius:14px; padding:10px; font-size:13px; margin-bottom:14px;
}
.errors{
  background:#ffe5e5; border:2px solid #ffb5b5; color:#b91c1c;
  border-radius:14px; padding:10px; font-size:13px; margin-top:10px;
}
.comment-item{
  border:2px solid #cfe5ff;
  background:#f5faff;
  border-radius:16px;
  padding:12px;
  margin-top:10px;
}
.small{ font-size:12px; color:#64748b; }
</style>

<div class="wrap">

  @if(session('success'))
    <div class="success">{{ session('success') }}</div>
  @endif

  {{-- 曲情報 --}}
  <div class="card">
    <div class="row">
      <div class="thumb">
        {{-- YouTube/SoundCloud埋め込み（URLそのままだとダメなので簡易対応：YouTubeのみ） --}}
        @php
          $url = $song->url ?? '';
          $embed = null;
          if (preg_match('/[?&]v=([^&]+)/', $url, $m)) $embed = 'https://www.youtube.com/embed/'.$m[1];
          if (preg_match('/youtu\.be\/([^?&]+)/', $url, $m)) $embed = 'https://www.youtube.com/embed/'.$m[1];
          if (preg_match('/youtube\.com\/shorts\/([^?&]+)/', $url, $m)) $embed = 'https://www.youtube.com/embed/'.$m[1];
        @endphp

        @if($embed)
          <iframe src="{{ $embed }}" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        @else
          <div style="padding:12px" class="muted">
            プレビュー非対応URLです。<br>
            <a href="{{ $song->url }}" target="_blank" rel="noopener" style="color:#2563eb;font-weight:900;">リンクを開く</a>
          </div>
        @endif
      </div>

      <div class="meta">
        <div class="h1">{{ $song->title }}</div>
        <div class="muted">Artist：{{ $song->artist }}</div>
        <div class="muted">Genre：{{ $song->genre }}</div>
        <div style="margin-top:10px;">
          <span class="badge">投稿者：{{ $song->user->name ?? 'unknown' }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- ★評価 --}}
  <div class="card">
    <h3 class="section-title">★評価</h3>

    <div class="muted" style="margin-bottom:12px;">
      平均：<b>{{ $avgRating ?? '---' }}</b>（{{ $ratingCount ?? 0 }}件）
      @auth / あなた：<b>{{ $myRating ?? '未評価' }}</b> @endauth
    </div>

    @guest
      <div class="muted">評価するにはログインが必要です。</div>
    @else
      <form id="voteForm" action="{{ route('vote.store', $song->id) }}" method="POST">
        @csrf

        <div class="rating-wrap">
          @for($i=1; $i<=5; $i++)
            <input
              type="radio"
              id="rate{{ $i }}"
              name="rating"
              value="{{ $i }}"
              {{ (int)old('rating', $myRating ?? 0) === $i ? 'checked' : '' }}
              onchange="document.getElementById('voteForm').submit();"
            >
            <label for="rate{{ $i }}" class="rate-btn">{{ $i }}★</label>
          @endfor
        </div>

        <button type="submit" class="btn">評価を送信</button>
      </form>

      @error('rating')
        <div class="errors">{{ $message }}</div>
      @enderror
    @endguest
  </div>

  {{-- コメント --}}
  <div class="card">
    <h3 class="section-title">コメント</h3>

    @auth
      <form action="{{ route('comment.store', $song->id) }}" method="POST">
        @csrf
        <textarea name="comment" class="textarea" placeholder="コメントを入力...">{{ old('comment') }}</textarea>
        <button type="submit" class="btn">コメントする</button>
      </form>

      @error('comment')
        <div class="errors">{{ $message }}</div>
      @enderror
    @else
      <div class="muted">コメントするにはログインが必要です。</div>
    @endauth

    <div style="margin-top:14px;">
      @forelse($comments as $c)
        <div class="comment-item">
          <div style="font-weight:900;">{{ $c->user->name ?? 'unknown' }}</div>
          <div style="margin-top:6px;">{{ $c->comment }}</div>
          <div class="small" style="margin-top:6px;">{{ $c->created_at }}</div>
        </div>
      @empty
        <div class="muted">まだコメントはありません。</div>
      @endforelse
    </div>
  </div>

</div>
@endsection
