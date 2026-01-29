@extends('layouts.app')

@section('content')
<style>
/* ======（あなたのCSSそのまま + スマホ強化）====== */
*, *::before, *::after { box-sizing: border-box; }

.profile-container{ max-width: 1100px; margin: 32px auto; padding: 0 16px; }
.top-grid{ display:grid; grid-template-columns:1fr 1fr; gap:22px; align-items:start; margin-bottom:28px; }
.card{ background: var(--card, #fff); border:2px solid var(--border, #dbeafe); border-radius:22px; padding:22px; box-shadow:0 8px 24px rgba(0,0,0,.06); }
.profile-card{ display:flex; gap:18px; align-items:center; min-width:0; }
.profile-icon{ width:92px; height:92px; border-radius:18px; object-fit:cover; border:2px solid var(--border, #dbeafe); background:#f1f5f9; flex-shrink:0; }
.profile-info{ min-width:0; }
.profile-info h1{ font-size:22px; font-weight:900; margin:0 0 4px; overflow-wrap:anywhere; }
.profile-info p{ font-size:14px; opacity:.7; margin:0 0 10px; overflow-wrap:anywhere; }
.badge-login{ display:inline-flex; align-items:center; gap:6px; font-size:13px; padding:6px 12px; border-radius:999px; background:#e7f7ff; color:#0369a1; border:1px solid #bae6fd; width:fit-content; }

.icon-box h2{ font-size:18px; font-weight:900; margin:0 0 6px; }
.icon-box p{ font-size:13px; opacity:.7; margin:0 0 14px; }
.file-wrap{ display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:16px; border:2px solid var(--border, #dbeafe); background: var(--bg, #f5faff); overflow:hidden; min-width:0; }
.file-input{ position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0 0 0 0); clip-path:inset(50%); }
.file-btn{ padding:8px 14px; border-radius:14px; background:#eaf3ff; border:2px solid var(--border, #dbeafe); font-size:14px; font-weight:800; cursor:pointer; white-space:nowrap; flex-shrink:0; }
.file-name{ flex:1; min-width:0; font-size:14px; opacity:.75; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.update-btn{ margin-top:16px; width:100%; padding:14px 0; border-radius:999px; border:none; background: var(--text-blue, #3b82f6); color:#fff; font-weight:900; cursor:pointer; }

.three-grid{ display:grid; grid-template-columns:repeat(3, 1fr); gap:20px; }
.panel{ background: var(--card, #fff); border:2px solid var(--border, #dbeafe); border-radius:22px; padding:20px; min-height:180px; min-width:0; }
.panel h3{ font-size:17px; font-weight:900; margin:0 0 12px; }

/* ✅ 投稿一覧 */
.my-songs{
  margin-top: 22px;
  background: var(--card, #fff);
  border:2px solid var(--border, #dbeafe);
  border-radius:22px;
  padding:20px;
}
.my-songs h2{ font-size:18px; font-weight:900; margin:0 0 12px; }
.song-row{
  display:flex; justify-content:space-between; align-items:center;
  gap:12px; padding:12px 0; border-top:1px dashed var(--border, #dbeafe);
  min-width:0;
}
.song-row:first-of-type{ border-top:none; }
.song-title{ font-weight:900; color: var(--text-blue, #3b82f6); text-decoration:none; overflow-wrap:anywhere; }
.song-meta{ font-size:13px; opacity:.7; margin-top:4px; overflow-wrap:anywhere; }
.actions{ display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end; }
.btn-mini{
  padding:8px 12px; border-radius:999px; border:2px solid var(--border, #dbeafe);
  background:#fff; cursor:pointer; font-weight:900; font-size:13px;
}
.btn-edit{ color:#0f766e; }
.btn-del{ color:#b91c1c; }

/* ✅ お気に入り一覧 */
.fav-box{
  margin-top: 22px;
  background: var(--card, #fff);
  border:2px solid var(--border, #dbeafe);
  border-radius:22px;
  padding:20px;
}
.fav-box h2{ font-size:18px; font-weight:900; margin:0 0 12px; }
.fav-row{
  display:flex; justify-content:space-between; align-items:center;
  gap:12px; padding:12px 0; border-top:1px dashed var(--border, #dbeafe);
  min-width:0;
}
.fav-row:first-of-type{ border-top:none; }
.fav-right{ display:flex; gap:10px; align-items:center; flex-wrap:wrap; justify-content:flex-end; }
.badge-mini{
  padding:6px 10px;
  border-radius:999px;
  border:2px solid var(--border,#dbeafe);
  background:#fff;
  font-weight:900;
  font-size:12px;
  opacity:.85;
}

/* ✅ スマホ最適化 */
@media (max-width:980px){
  .top-grid{ grid-template-columns:1fr; }
  .three-grid{ grid-template-columns:1fr; }
  .profile-card{ flex-direction:column; text-align:center; align-items:center; }
  .badge-login{ margin:0 auto; }
}

@media (max-width:560px){
  .card, .panel, .my-songs, .fav-box{ padding:16px; border-radius:18px; }
  .profile-icon{ width:84px; height:84px; }
  .song-row, .fav-row{ flex-direction:column; align-items:flex-start; }
  .actions, .fav-right{ width:100%; justify-content:flex-start; }
  .btn-mini{ width:auto; }
}
</style>

<div class="profile-container">

  <div class="top-grid">
    <div class="card profile-card">
      <img
        src="{{ auth()->user()->icon_url }}"
        class="profile-icon"
        alt="icon"
        onerror="this.onerror=null;this.src='{{ asset('images/default_icon.png') }}';"
      >
      <div class="profile-info">
        <h1>{{ Auth::user()->name }}</h1>
        <p>{{ Auth::user()->email }}</p>
        <span class="badge-login">ログイン中 ✅</span>
      </div>
    </div>

    <div class="card icon-box">
      <h2>プロフィールアイコンを変更</h2>
      <p>画像を選択して「更新する」を押してください。</p>

      <form action="{{ route('profile.icon') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="file-wrap">
          <input type="file" name="icon" accept="image/*" required class="file-input" id="iconInput">
          <span class="file-btn">ファイルを選択</span>
          <span class="file-name" id="fileName">ファイルが選択されていません</span>
        </label>

        <button type="submit" class="update-btn">更新する</button>
      </form>
    </div>
  </div>

  <div class="three-grid">

    <div class="panel">
      <h3>My ベストソング</h3>
      @forelse($bestSongs as $s)
        <div style="margin:10px 0;">
          <a class="song-title" href="{{ route('music.show', $s->id) }}">{{ $s->title }}</a>
          <div class="song-meta">{{ $s->artist }}</div>
        </div>
      @empty
        <p>まだ投稿がありません。</p>
      @endforelse
    </div>

    <div class="panel">
      <h3>好きなジャンル</h3>
      @if(($favoriteGenres ?? collect())->count())
        <div style="display:flex;flex-wrap:wrap;gap:10px;">
          @foreach($favoriteGenres as $g)
            <span style="padding:8px 12px;border-radius:999px;border:2px solid var(--border,#dbeafe);background:#fff;font-weight:900;">
              {{ $g }}
            </span>
          @endforeach
        </div>
      @else
        <p>（ジャンルがまだありません）</p>
      @endif
    </div>

    <div class="panel">
      <h3>お気に入り数ランキング</h3>

      @if(($favoriteRanking ?? collect())->count())
        @foreach($favoriteRanking as $row)
          <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;gap:10px;">
            <div style="font-weight:900;min-width:0;overflow-wrap:anywhere;">{{ $row['label'] }}</div>
            <div style="opacity:.7;font-weight:900;white-space:nowrap;">{{ $row['count'] }}回</div>
          </div>

          <div style="margin-top:8px;border:2px solid var(--border,#dbeafe);border-radius:999px;overflow:hidden;background:#fff;">
            <div style="height:10px;width:{{ $row['pct'] }}%;background:var(--text-blue,#3b82f6);"></div>
          </div>
        @endforeach
      @else
        <p>（まだお気に入りされていません）</p>
      @endif
    </div>

  </div>

  <div class="my-songs">
    <h2>投稿した曲（編集・削除）</h2>

    @forelse($mySongs as $s)
      <div class="song-row">
        <div style="min-width:0;">
          <a class="song-title" href="{{ route('music.show', $s->id) }}">{{ $s->title }}</a>
          <div class="song-meta">{{ $s->artist }} / {{ $s->created_at }}</div>
        </div>

        <div class="actions">
          <a class="btn-mini btn-edit" href="{{ route('songs.edit', $s->id) }}">編集</a>

          <form action="{{ route('songs.destroy', $s->id) }}" method="POST"
                onsubmit="return confirm('この曲を削除しますか？');">
            @csrf
            @method('DELETE')
            <button class="btn-mini btn-del" type="submit">削除</button>
          </form>
        </div>
      </div>
    @empty
      <p>まだ投稿がありません。</p>
    @endforelse
  </div>

  <div class="fav-box">
    <h2>お気に入り一覧</h2>

    @if(($favoriteSongs ?? collect())->count())
      @foreach($favoriteSongs as $s)
        <div class="fav-row">
          <div style="min-width:0;">
            <a class="song-title" href="{{ route('music.show', $s->id) }}">{{ $s->title }}</a>
            <div class="song-meta">
              {{ $s->artist }} / 投稿者：{{ $s->user->name ?? 'unknown' }}
            </div>
          </div>

          <div class="fav-right">
            @if(!empty($s->genre))
              <span class="badge-mini">{{ $s->genre }}</span>
            @endif

            <form method="POST" action="{{ route('favorite.toggle', $s->id) }}">
              @csrf
              <button class="btn-mini btn-del" type="submit">解除</button>
            </form>
          </div>
        </div>
      @endforeach
    @else
      <p>（お気に入りがまだありません）</p>
    @endif
  </div>

</div>

<script>
document.getElementById('iconInput')?.addEventListener('change', function(){
  document.getElementById('fileName').textContent =
    this.files[0]?.name ?? 'ファイルが選択されていません';
});
</script>
@endsection
