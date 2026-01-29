@extends('layouts.app')

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }
.wrap{ max-width: 980px; margin: 28px auto; padding: 0 16px; }
.card{
  background: var(--card);
  border:2px solid var(--border);
  border-radius:22px;
  padding:24px;
  box-shadow:0 12px 30px var(--shadow);
}
.h1{ font-size:24px; font-weight:900; color: var(--text-blue); margin:0 0 10px; }
.muted{ color: var(--muted); font-size:13px; }

.top{
  display:grid;
  grid-template-columns: 220px 1fr;
  gap:16px;
  align-items:start;
}
@media (max-width: 720px){ .top{ grid-template-columns: 1fr; } }

.thumb{
  width:220px; height:220px;
  border-radius:18px;
  border:2px solid var(--border);
  overflow:hidden;
  background: var(--bg);
}
.thumb img{ width:100%; height:100%; object-fit:cover; display:block; }

.meta{
  border:2px solid var(--border);
  border-radius:18px;
  padding:14px 16px;
  background: var(--bg);
}
.meta .row{ margin:6px 0; font-size:14px; color: var(--text); }
.badge{
  display:inline-block;
  margin-top:10px;
  padding:8px 12px;
  border-radius:999px;
  border:2px solid var(--border);
  background: var(--card);
  font-weight:900;
  color: var(--text);
}
.link{
  display:inline-block;
  margin-top:10px;
  font-weight:900;
  color: var(--text-blue);
  text-decoration:none;
}
.link:hover{ text-decoration:underline; }

.hr{ margin:18px 0; border-top:2px dashed var(--border); }

.grid3{
  margin-top: 12px;
  display:flex;
  flex-direction: column;
  gap: 18px;
}

.box{
  border:2px solid var(--border);
  border-radius:18px;
  padding:16px;
  background: var(--card);
}
.box-title{ font-size:16px; font-weight:900; color: var(--text-blue); margin:0 0 10px; }
.box p{ margin:0; line-height:1.7; font-size:14px; color: var(--text); }

.btn{
  width:100%;
  margin-top:10px;
  padding:14px 0;
  border:none;
  border-radius:999px;
  font-weight:900;
  font-size:15px;
  color:#fff;
  background: var(--text-blue);
  cursor:pointer;
}
.btn:hover{ opacity:.95; }

textarea{
  width:100%;
  max-width:100%;
  min-height: 110px;
  padding:12px 14px;
  border-radius:14px;
  border:2px solid var(--border);
  background: var(--bg);
  font-size:14px;
  color: var(--text);
}

.star-row{ display:flex; gap:10px; flex-wrap:wrap; margin-top:10px; }
.star-btn{
  border:2px solid var(--border);
  background: var(--card);
  color: var(--text);
  border-radius:999px;
  padding:10px 14px;
  font-weight:900;
  cursor:pointer;
}
.star-btn:hover{ border-color: var(--text-blue); }

.comment-item{
  border:2px solid var(--border);
  background: var(--bg);
  border-radius:16px;
  padding:12px;
  margin-top:10px;
}
.comment-head{ display:flex; align-items:center; justify-content:space-between; gap:10px; }
.comment-user{ display:flex; align-items:center; gap:10px; font-weight:900; color: var(--text); }

/* ✅ コメント用：画像＋1文字フォールバック（サイズは既存と同じ） */
.cicon-img{
  width:34px; height:34px;
  border-radius:50%;
  object-fit:cover;
  border:2px solid var(--border);
  background: var(--card);
  display:block;
}
.cicon-initial{
  width:34px; height:34px;
  border-radius:50%;
  border:2px solid var(--border);
  background: var(--text-blue);
  color:#fff;
  font-weight:900;
  font-size:14px;
  display:none;
  align-items:center;
  justify-content:center;
  flex:0 0 auto;
}
.cicon-initial.show{ display:flex; }

.comment-time{ color: var(--muted); font-size:12px; }
</style>

@php
  $fallback = asset('images/アイコン.png');
  $avg = isset($avgRating) ? (float)$avgRating : 0.0;
  $avgText = number_format($avg, 1);
@endphp

<div class="wrap">
  <div class="card">

    <h1 class="h1">{{ $song->title }}</h1>

    <div class="top">
      <div class="thumb">
        <img
          src="{{ $thumbnailUrl ?? $fallback }}"
          alt="thumbnail"
          onerror="this.onerror=null;this.src='{{ $fallback }}';"
        >
      </div>

      <div class="meta">
        <div class="row">アーティスト：<b>{{ $song->artist }}</b></div>
        <div class="row">投稿者：<b>{{ $song->user->name ?? 'unknown' }}</b></div>
        <div class="row">平均評価：<b>{{ $avgText }}</b></div>

        @if(!empty($song->genre))
          <div class="badge">{{ $song->genre }}</div>
        @endif

        <a class="link" href="{{ $song->url }}" target="_blank" rel="noopener">▶ URL を開く</a>
      </div>
    </div>

    <div class="hr"></div>

    <div class="grid3">

      <div class="box">
        <div class="box-title">投稿コメント</div>
        <p>{{ $song->comment ?: '（投稿コメントはありません）' }}</p>
      </div>

      <div class="box">
        <div class="box-title">お気に入り</div>

        @auth
          <form method="POST" action="{{ route('favorite.toggle', $song->id) }}">
            @csrf
            <button class="btn" type="submit">
              {{ !empty($isFavorited) ? '★ お気に入り解除' : '☆ お気に入り登録' }}
            </button>
          </form>
          <div class="muted" style="margin-top:8px;">
            {{ !empty($isFavorited) ? 'この曲はお気に入り済みです。' : 'あとで聴きたい曲を保存できます。' }}
          </div>
        @else
          <div class="muted">お気に入り登録するにはログインしてください。</div>
        @endauth
      </div>

      <div class="box">
        <div class="box-title">★評価</div>

        <div style="font-weight:900;font-size:18px; color: var(--text);">
          平均：{{ $avgText }}
          <span class="muted" style="margin-left:10px;">あなたの評価：{{ $myRating ?? '-' }}</span>
        </div>

        @auth
          <form method="POST" action="{{ route('vote.store', $song->id) }}">
            @csrf
            <div class="star-row">
              @for($i=1;$i<=5;$i++)
                <button class="star-btn" type="submit" name="rating" value="{{ $i }}">
                  {{ $i }} ★
                </button>
              @endfor
            </div>
            <div class="muted" style="margin-top:8px;">※同じ曲は上書き保存になります</div>
          </form>
        @else
          <div class="muted" style="margin-top:10px;">評価するにはログインしてください。</div>
        @endauth
      </div>

      <div class="box">
        <div class="box-title">コメント</div>

        @auth
          <form method="POST" action="{{ route('comment.store', $song->id) }}">
            @csrf
            <textarea name="comment" maxlength="500" placeholder="コメントを入力（最大500文字）"></textarea>
            <button class="btn" type="submit">コメントする</button>
          </form>
        @else
          <div class="muted">コメントするにはログインしてください。</div>
        @endauth

        @forelse($comments as $c)
          @php
            $cu = $c->user; // comment user
            $cname = $cu->name ?? 'unknown';
            $cinitial = mb_substr($cname, 0, 1);
            $cicon = $cu?->icon_url; // null の可能性あり
          @endphp

          <div class="comment-item">
            <div class="comment-head">
              <div class="comment-user">
                @if($cicon)
                  <img
                    src="{{ $cicon }}"
                    class="cicon-img"
                    alt="icon"
                    onerror="this.style.display='none';this.nextElementSibling.classList.add('show');"
                  >
                  <span class="cicon-initial">{{ $cinitial }}</span>
                @else
                  <span class="cicon-initial show">{{ $cinitial }}</span>
                @endif

                {{ $cname }}
              </div>
              <div class="comment-time">{{ $c->created_at }}</div>
            </div>

            <div style="margin-top:8px; font-size:14px; line-height:1.7; color: var(--text);">
              {{ $c->comment }}
            </div>
          </div>
        @empty
          <div class="muted" style="margin-top:12px;">まだコメントがありません。</div>
        @endforelse

      </div>

    </div>

  </div>
</div>
@endsection
