@extends('layouts.app')

@section('content')
<style>
/* ===== はみ出し防止（超重要） ===== */
*, *::before, *::after { box-sizing: border-box; }

/* ===== Layout ===== */
.wrap { max-width: 820px; margin: 32px auto; padding: 0 16px; }
.card{
    background: var(--card-bg, #fff);
    border: 2px solid var(--border, #cfe5ff);
    border-radius: 22px;
    padding: 24px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
}
.title{ font-size: 22px; font-weight: 900; color: var(--text-blue, #3b82f6); margin-bottom: 6px; }
.desc{ font-size: 13px; color: var(--muted, #64748b); margin-bottom: 18px; }

/* 2列（スマホで1列） */
.grid-2{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 640px){
    .grid-2{ grid-template-columns: 1fr; }
}

.form-group{ margin-bottom: 16px; }
label{
    display:block; font-size: 13px; font-weight: 800;
    color: var(--text-blue, #3b82f6); margin-bottom: 6px;
}

/* ===== Inputs（はみ出し完全防止） ===== */
input, textarea{
    width: 100%;
    max-width: 100%;
    display:block;
    padding: 12px 14px;
    border-radius: 14px;
    border: 2px solid var(--border, #cfe5ff);
    background: var(--bg, #f5faff);
    font-size: 14px;
    color: var(--text, #0f172a);
}
textarea{ min-height: 120px; resize: vertical; }

/* ===== Tag UI (checkbox) ===== */
.tag-wrap{
    display:flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 12px;
    border-radius: 16px;
    border: 2px solid var(--border, #cfe5ff);
    background: var(--bg, #f5faff);
}
.tag{
    position: relative;
    display: inline-flex;
    align-items: center;
}
.tag input{
    position:absolute;
    opacity:0;
    pointer-events:none;
}
.tag span{
    display:inline-flex;
    align-items:center;
    gap: 6px;
    padding: 8px 12px;
    border-radius: 999px;
    border: 2px solid var(--border, #cfe5ff);
    background: #fff;
    color: var(--text, #0f172a);
    font-size: 13px;
    font-weight: 800;
    cursor:pointer;
    user-select:none;
    transition: .15s;
    white-space: nowrap;
}
.tag input:checked + span{
    border-color: var(--text-blue, #3b82f6);
    background: rgba(59,130,246,.12);
    color: var(--text-blue, #3b82f6);
}
.tag input:checked + span::before{
    content:"✓";
    font-weight: 900;
}

/* ===== Preview ===== */
.preview-card{
    margin-top: 14px;
    border-radius: 18px;
    border: 2px solid var(--border, #cfe5ff);
    background: var(--bg, #f5faff);
    padding: 14px;
}
.preview-title{
    font-size: 13px;
    font-weight: 900;
    color: var(--text-blue, #3b82f6);
    margin-bottom: 10px;
}
.preview-box{
    width: 100%;
    border-radius: 14px;
    overflow: hidden;
    border: 2px solid var(--border, #cfe5ff);
    background:#fff;
}
.preview-iframe{
    width: 100%;
    height: 360px;
    border: 0;
    display:block;
}
@media (max-width: 640px){
    .preview-iframe{ height: 240px; }
}
.preview-note{
    font-size: 12px;
    color: var(--muted, #64748b);
    margin-top: 10px;
    line-height: 1.6;
}

/* ===== Messages ===== */
.errors{
    background: #ffe5e5;
    border: 2px solid #ffb5b5;
    color: #b91c1c;
    border-radius: 14px;
    padding: 12px;
    font-size: 13px;
    margin-bottom: 16px;
}

/* ===== Buttons ===== */
.btn{
    width: 100%;
    margin-top: 8px;
    padding: 14px 0;
    border: none;
    border-radius: 999px;
    font-weight: 900;
    font-size: 15px;
    color: #fff;
    background: var(--text-blue, #3b82f6);
    cursor: pointer;
}
.btn:hover{ opacity: .95; }

.back{
    margin-top: 14px;
    text-align:center;
    font-size: 13px;
}
.back a{
    color: var(--text-blue, #3b82f6);
    font-weight: 900;
    text-decoration: none;
}
</style>

<div class="wrap">
    <div class="card">

        <h1 class="title">曲を投稿する</h1>
        <p class="desc">URL、タイトル、アーティスト、ジャンル（複数OK）を入力して投稿できます。</p>

        @if ($errors->any())
            <div class="errors">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>・{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('songs.store') }}">
            @csrf

            <div class="form-group">
                <label>URL（YouTube / SoundCloud など）</label>
                <input id="urlInput" type="text" name="url" placeholder="https://..." value="{{ old('url') }}" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>タイトル</label>
                    <input type="text" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label>アーティスト</label>
                    <input type="text" name="artist" value="{{ old('artist') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>ジャンル（複数選択OK）</label>

                @if(isset($genres) && $genres->count())
                    <div class="tag-wrap">
                        @foreach($genres as $genre)
                            <label class="tag">
                                <input
                                    type="checkbox"
                                    name="genre_ids[]"
                                    value="{{ $genre->id }}"
                                    {{ in_array($genre->id, old('genre_ids', [])) ? 'checked' : '' }}
                                >
                                <span>{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="preview-note" style="margin-top:8px;">
                        ※ジャンルは複数選択できます（例：ボカロ + Lo-Fi）。
                    </div>
                @else
                    <div class="preview-note">
                        ジャンルが登録されていません。先に genres テーブルへデータを追加してください。
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>コメント（任意）</label>
                <textarea name="comment">{{ old('comment') }}</textarea>
            </div>

            {{-- ✅ URLプレビュー --}}
            <div class="preview-card">
                <div class="preview-title">プレビュー</div>
                <div class="preview-box">
                    <iframe id="previewFrame" class="preview-iframe" src="" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
                <div id="previewNote" class="preview-note">
                    URLを入力すると、YouTube / SoundCloud のプレビューが表示されます。
                </div>
            </div>

            <button type="submit" class="btn">投稿する</button>

            <div class="back">
                <a href="{{ route('home') }}">← トップへ戻る</a>
            </div>
        </form>

    </div>
</div>

<script>
(function(){
    const urlInput = document.getElementById('urlInput');
    const frame = document.getElementById('previewFrame');
    const note = document.getElementById('previewNote');

    function toYouTubeEmbed(url){
        const watch = url.match(/[?&]v=([^&]+)/);
        if (watch && watch[1]) return "https://www.youtube.com/embed/" + watch[1];

        const short = url.match(/youtu\.be\/([^?&]+)/);
        if (short && short[1]) return "https://www.youtube.com/embed/" + short[1];

        const shorts = url.match(/youtube\.com\/shorts\/([^?&]+)/);
        if (shorts && shorts[1]) return "https://www.youtube.com/embed/" + shorts[1];

        return null;
    }

    function toSoundCloudEmbed(url){
        const enc = encodeURIComponent(url);
        return "https://w.soundcloud.com/player/?url=" + enc;
    }

    function updatePreview(){
        const url = (urlInput.value || "").trim();
        if(!url){
            frame.src = "";
            note.textContent = "URLを入力すると、YouTube / SoundCloud のプレビューが表示されます。";
            return;
        }

        const yt = toYouTubeEmbed(url);
        if(yt){
            frame.src = yt;
            note.textContent = "YouTube プレビュー表示中";
            return;
        }

        if(url.includes("soundcloud.com")){
            frame.src = toSoundCloudEmbed(url);
            note.textContent = "SoundCloud プレビュー表示中";
            return;
        }

        frame.src = "";
        note.textContent = "このURLはプレビュー非対応です（YouTube / SoundCloud 推奨）。";
    }

    urlInput.addEventListener('input', updatePreview);
    updatePreview();
})();
</script>
@endsection
