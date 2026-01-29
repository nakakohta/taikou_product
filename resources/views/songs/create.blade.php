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

/* プレビュー（はみ出し防止） */
.preview-box{ margin-top:22px; }
.preview-title{ font-weight:900; margin-bottom:8px; }
.preview-frame{
  width:100%;
  aspect-ratio: 16 / 9;
  border-radius:18px;
  border:2px solid #dbeafe;
  background:#f8fbff;
  overflow:hidden;
  position:relative;
}
.preview-inner{
  position:absolute; inset:0;
  display:flex; align-items:center; justify-content:center;
}
.preview-inner img{
  max-width:100%;
  max-height:100%;
  width:auto;
  height:auto;
  object-fit:contain;
  display:block;
}

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
.muted{
  margin-top:6px;
  color:#64748b;
  font-size:12px;
}
</style>

<div class="wrap">
  <div class="card">
    <div class="h1">曲を投稿</div>

    {{-- バリデーション表示 --}}
    @if ($errors->any())
      <div class="err">
        @foreach ($errors->all() as $e)
          <div>・{{ $e }}</div>
        @endforeach
      </div>
    @endif

    <form id="songForm" method="POST" action="{{ route('songs.store') }}">
      @csrf

      <div class="label">URL</div>
      <input class="input" type="text" name="url" id="urlInput" value="{{ old('url') }}" required>
      <div class="muted">※ YouTube（youtube.com / youtu.be）のURLのみ投稿できます。</div>

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
      <input class="input" type="text" name="title" value="{{ old('title') }}" required>

      <div class="label">アーティスト</div>
      <input class="input" type="text" name="artist" value="{{ old('artist') }}" required>

      <div class="label">ジャンル（複数選択可）</div>
      <div class="genre-wrap" id="genreWrap">
        @foreach($genres as $genre)
          <button type="button" class="genre-btn" data-value="{{ $genre->name }}">
            {{ $genre->name }}
          </button>
        @endforeach
      </div>

      {{-- ✅ これが送信される（複数なら "A, B"） --}}
      <input type="hidden" name="genre" id="genreInput" value="{{ old('genre') }}">

      <div class="label">コメント（任意）</div>
      <textarea name="comment" maxlength="500">{{ old('comment') }}</textarea>

      <button class="btn" type="submit">投稿する</button>
    </form>
  </div>
</div>

<script>
(() => {
  const form      = document.getElementById('songForm');
  const urlInput  = document.getElementById('urlInput');
  const preview   = document.getElementById('previewImage');
  const genreBtns = document.querySelectorAll('.genre-btn');
  const genreInput= document.getElementById('genreInput');

  const defaultThumb = "{{ asset('images/default_thumb.png') }}";

  // ===== YouTube判定（ドメイン） =====
  function isYoutubeUrl(raw){
    try{
      const u = new URL(raw.trim());
      const host = u.hostname.replace(/^www\./,'').toLowerCase();
      return (host === 'youtube.com' || host.endsWith('.youtube.com') || host === 'youtu.be');
    }catch(e){
      return false;
    }
  }

  // ===== YouTube ID 抽出（watch?v= / youtu.be/ / shorts/ / embed/）=====
  function getYoutubeId(raw){
    try{
      const u = new URL(raw.trim());
      const host = u.hostname.replace(/^www\./,'').toLowerCase();

      // youtu.be/VIDEOID
      if(host === 'youtu.be'){
        const id = u.pathname.split('/').filter(Boolean)[0];
        return id || null;
      }

      // youtube.com/watch?v=VIDEOID
      const v = u.searchParams.get('v');
      if(v) return v;

      // youtube.com/shorts/VIDEOID
      const p = u.pathname.split('/').filter(Boolean);
      const idxShorts = p.indexOf('shorts');
      if(idxShorts >= 0 && p[idxShorts+1]) return p[idxShorts+1];

      // youtube.com/embed/VIDEOID
      const idxEmbed = p.indexOf('embed');
      if(idxEmbed >= 0 && p[idxEmbed+1]) return p[idxEmbed+1];

      return null;
    }catch(e){
      return null;
    }
  }

  // ===== サムネ更新 =====
  function setPreview(){
    const url = urlInput.value.trim();
    if(!url || !isYoutubeUrl(url)){
      preview.src = defaultThumb;
      return;
    }
    const id = getYoutubeId(url);
    if(id){
      preview.src = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
    }else{
      preview.src = defaultThumb;
    }
  }

  urlInput.addEventListener('input', setPreview);
  setPreview();

  // ===== ジャンル複数選択（復元含む）=====
  let selected = [];

  if(genreInput.value){
    selected = genreInput.value.split(',').map(s=>s.trim()).filter(Boolean);
    genreBtns.forEach(btn=>{
      if(selected.includes(btn.dataset.value)) btn.classList.add('active');
    });
  }

  genreBtns.forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const v = btn.dataset.value;
      if(selected.includes(v)){
        selected = selected.filter(x=>x!==v);
        btn.classList.remove('active');
      }else{
        selected.push(v);
        btn.classList.add('active');
      }
      genreInput.value = selected.join(', ');
    });
  });

  // ===== 送信前チェック（YouTubeのみ + ジャンル必須）=====
  form.addEventListener('submit', (e)=>{
    const url = urlInput.value.trim();

    if(!url || !isYoutubeUrl(url)){
      e.preventDefault();
      alert('YouTube（youtube.com / youtu.be）のURLのみ投稿できます。');
      return;
    }

    // IDが取れないURLは弾く（YouTube内でも変なURL対策）
    const id = getYoutubeId(url);
    if(!id){
      e.preventDefault();
      alert('YouTube動画IDを含むURLを入力してください。');
      return;
    }

    if(!genreInput.value.trim()){
      e.preventDefault();
      alert('ジャンルを1つ以上選択してください。');
      return;
    }
  });
})();
</script>
@endsection
