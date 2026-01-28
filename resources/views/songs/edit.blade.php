@extends('layouts.app')

@section('content')
<style>
*,
*::before,
*::after{ box-sizing:border-box; }

.wrap{ max-width:760px;margin:28px auto;padding:0 16px; }
.card{
  background:#fff;border:2px solid #dbeafe;border-radius:22px;
  padding:24px;box-shadow:0 12px 30px rgba(0,0,0,.06);
}
.h1{ font-size:22px;font-weight:900;color:#3b82f6;margin:0 0 16px; }
.label{ font-weight:900;margin:18px 0 6px; }
.input, textarea{
  width:100%;border-radius:14px;border:2px solid #dbeafe;
  padding:12px 14px;font-size:14px;
}
textarea{ min-height:120px; }

.btn{
  margin-top:22px;width:100%;padding:14px 0;border:none;border-radius:999px;
  background:#3b82f6;color:#fff;font-weight:900;font-size:15px;cursor:pointer;
}

/* ジャンルボタン */
.genre-wrap{ display:flex; flex-wrap:wrap; gap:10px; }
.genre-btn{
  padding:8px 14px; border-radius:999px; border:2px solid #dbeafe;
  background:#fff; font-weight:900; font-size:13px; cursor:pointer;
}
.genre-btn.active{ background:#3b82f6; color:#fff; border-color:#3b82f6; }

/* プレビュー：はみ出し完全防止 */
.preview-box{ margin-top:22px; }
.preview-title{ font-weight:900; margin-bottom:8px; }
.preview-frame{
  width:100%;
  aspect-ratio:16/9;
  border-radius:18px;
  border:2px solid #dbeafe;
  background:#f8fbff;
  overflow:hidden;
  position:relative;
}
.preview-inner{
  position:absolute; inset:0;
  display:flex; align-items:center; justify-content:center;
  padding:10px;
}
.preview-inner img{
  max-width:100%;
  max-height:100%;
  width:auto;
  height:auto;
  object-fit:contain;
  display:block;
}

/* エラー表示 */
.err{
  margin-top:10px;
  padding:10px 12px;
  border:2px solid #fecaca;
  background:#fff1f2;
  color:#b91c1c;
  border-radius:14px;
  font-weight:900;
  font-size:13px;
}
.muted{ opacity:.7; font-size:13px; margin-top:6px; }
</style>

<div class="wrap">
  <div class="card">
    <div class="h1">投稿を編集</div>

    @if ($errors->any())
      <div class="err">
        @foreach ($errors->all() as $e)
          <div>・{{ $e }}</div>
        @endforeach
      </div>
    @endif

    <form id="songEditForm" method="POST" action="{{ route('songs.update', $song->id) }}">
      @csrf
      @method('PUT')

      <div class="label">URL</div>
      <input class="input" type="text" name="url" id="urlInput"
             value="{{ old('url', $song->url) }}" required>

      <div class="preview-box">
        <div class="preview-title">プレビュー</div>
        <div class="preview-frame">
          <div class="preview-inner">
            <img
              id="previewImage"
              src="{{ asset('images/default_thumb.png') }}"
              alt="preview"
              onerror="this.onerror=null;this.src='{{ asset('images/default_thumb.png') }}';"
            >
          </div>
        </div>
      </div>

      <div class="label">曲名</div>
      <input class="input" type="text" name="title"
             value="{{ old('title', $song->title) }}" required>

      <div class="label">アーティスト</div>
      <input class="input" type="text" name="artist"
             value="{{ old('artist', $song->artist) }}" required>

      <div class="label">ジャンル（複数選択可）</div>
      <div class="genre-wrap">
        @foreach($genres as $genre)
          <button type="button" class="genre-btn" data-value="{{ $genre->name }}">
            {{ $genre->name }}
          </button>
        @endforeach
      </div>
      <div class="muted">※ジャンルは複数選択できます（例：ボカロ, Lo-Fi）</div>

      {{-- hiddenに "A, B" を入れて送る（これが無いと更新されない） --}}
      <input type="hidden" name="genre" id="genreInput" value="{{ old('genre', $song->genre) }}">

      <div class="label">コメント（任意）</div>
      <textarea name="comment" maxlength="500">{{ old('comment', $song->comment) }}</textarea>

      <button class="btn" type="submit">更新する</button>
    </form>
  </div>
</div>

<script>
/* ===== ジャンル複数選択（編集：初期値反映） ===== */
const genreBtns  = document.querySelectorAll('.genre-btn');
const genreInput = document.getElementById('genreInput');

let selected = [];
if (genreInput.value) {
  selected = genreInput.value.split(',').map(s => s.trim()).filter(Boolean);
}

function refreshButtons(){
  genreBtns.forEach(btn => {
    btn.classList.toggle('active', selected.includes(btn.dataset.value));
  });
}
refreshButtons();

genreBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    const v = btn.dataset.value;
    if (selected.includes(v)) selected = selected.filter(x => x !== v);
    else selected.push(v);

    genreInput.value = selected.join(', ');
    refreshButtons();
  });
});

/* 未選択送信防止 */
document.getElementById('songEditForm').addEventListener('submit', (e) => {
  if (!genreInput.value.trim()) {
    e.preventDefault();
    alert('ジャンルを1つ以上選択してください。');
  }
});

/* ===== URL → YouTubeサムネ ===== */
const urlInput = document.getElementById('urlInput');
const preview  = document.getElementById('previewImage');

function setPreview(){
  const url = urlInput.value || '';
  const yt = url.match(/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
  if (yt) preview.src = `https://img.youtube.com/vi/${yt[1]}/hqdefault.jpg`;
  else preview.src = "{{ asset('images/default_thumb.png') }}";
}
urlInput.addEventListener('input', setPreview);
setPreview();
</script>
@endsection
