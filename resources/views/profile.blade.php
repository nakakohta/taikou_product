@extends('layouts.app')

@section('content')
<style>
/* ===============================
   全体
================================ */
.profile-container{
    max-width: 1100px;
    margin: 32px auto;
    padding: 0 16px;
}

/* ✅ 上2項目を横並びにする枠 */
.top-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
    align-items: start;
    margin-bottom: 28px;
}

/* ===============================
   カード共通
================================ */
.card{
    background: var(--card, #fff);
    border: 2px solid var(--border, #dbeafe);
    border-radius: 22px;
    padding: 22px;
    box-shadow: 0 8px 24px rgba(0,0,0,.06);
}

/* ===============================
   プロフィールカード
================================ */
.profile-card{
    display: flex;
    gap: 18px;
    align-items: center;
}

/* アイコン巨大化防止 */
.profile-icon{
    width: 92px;
    height: 92px;
    border-radius: 18px;
    object-fit: cover;
    border: 2px solid var(--border, #dbeafe);
    background: #f1f5f9;
    flex-shrink: 0;
}

.profile-info h1{
    font-size: 22px;
    font-weight: 900;
    margin: 0 0 4px;
}

.profile-info p{
    font-size: 14px;
    opacity: .7;
    margin: 0 0 10px;
}

.badge-login{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #e7f7ff;
    color: #0369a1;
    border: 1px solid #bae6fd;
    width: fit-content;
}

/* ===============================
   アイコン更新
================================ */
.icon-box h2{
    font-size: 18px;
    font-weight: 900;
    margin: 0 0 6px;
}

.icon-box p{
    font-size: 13px;
    opacity: .7;
    margin: 0 0 14px;
}

/* ファイル選択：はみ出し完全防止 */
.file-wrap{
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 16px;
    border: 2px solid var(--border, #dbeafe);
    background: var(--bg, #f5faff);
    overflow: hidden;
}

.file-input{
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0 0 0 0);
    clip-path: inset(50%);
}

.file-btn{
    padding: 8px 14px;
    border-radius: 14px;
    background: #eaf3ff;
    border: 2px solid var(--border, #dbeafe);
    font-size: 14px;
    font-weight: 800;
    cursor: pointer;
    white-space: nowrap;
}

.file-name{
    flex: 1;
    min-width: 0;
    font-size: 14px;
    opacity: .75;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.update-btn{
    margin-top: 16px;
    width: 100%;
    padding: 14px 0;
    border-radius: 999px;
    border: none;
    background: var(--text-blue, #3b82f6);
    color: #fff;
    font-weight: 900;
    cursor: pointer;
}

/* ===============================
   下部3項目（横並び）
================================ */
.three-grid{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.panel{
    background: var(--card, #fff);
    border: 2px solid var(--border, #dbeafe);
    border-radius: 22px;
    padding: 20px;
    min-height: 180px;
}

.panel h3{
    font-size: 17px;
    font-weight: 900;
    margin: 0 0 12px;
}

/* ===============================
   レスポンシブ
================================ */
@media (max-width: 980px){
    .top-grid{
        grid-template-columns: 1fr; /* スマホでは縦 */
    }
    .three-grid{
        grid-template-columns: 1fr; /* スマホでは縦 */
    }
    .profile-card{
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
    .badge-login{
        margin: 0 auto;
    }
}
</style>

<div class="profile-container">

    {{-- ✅ 上段：2項目を横並び --}}
    <div class="top-grid">

        {{-- プロフィール --}}
        <div class="card profile-card">
            <img
                src="{{ auth()->user()->icon
                    ? asset('storage/'.auth()->user()->icon)
                    : asset('images/default_icon.png') }}"
                class="profile-icon"
                alt="icon"
            >
            <div class="profile-info">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->email }}</p>
                <span class="badge-login">ログイン中 ✅</span>
            </div>
        </div>

        {{-- アイコン変更 --}}
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

    {{-- ✅ 下段：3項目（横並び） --}}
    <div class="three-grid">
        <div class="panel">
            <h3>My ベストソング</h3>
            <p>まだ投稿がありません。</p>
        </div>

        <div class="panel">
            <h3>好きなジャンル</h3>
            <p>（ジャンルがまだありません）</p>
        </div>

        <div class="panel">
            <h3>好きな曲の集計</h3>
            <p>（集計データがありません）</p>
        </div>
    </div>

</div>

<script>
document.getElementById('iconInput').addEventListener('change', function(){
    document.getElementById('fileName').textContent =
        this.files[0]?.name ?? 'ファイルが選択されていません';
});
</script>
@endsection
