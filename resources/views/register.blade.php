@extends('layouts.app')

@section('content')

<style>
    /* ✅ 影響範囲を wrapper-register 内に限定 */
    .wrapper-register {
        width: 100%;
        max-width: 520px;
        margin: 40px auto;
        background: var(--card-bg);
        border-radius: 20px;
        padding: 28px 30px 36px;
        box-shadow: 0 8px 24px var(--shadow);
        border: 2px solid var(--border);
        box-sizing: border-box;
    }

    .wrapper-register .cat-image {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .wrapper-register .cat-image img {
        width: 110px;
        height: auto;
        border-radius: 18px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        animation: fuwafuwa 3s ease-in-out infinite;
    }

    @keyframes fuwafuwa {
        0% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0); }
    }

    .wrapper-register h1 {
        font-size: 20px;
        text-align: center;
        margin: 6px 0 10px;
        color: var(--text-blue);
        font-weight: 800;
    }

    .wrapper-register .subtitle {
        font-size: 13px;
        text-align: center;
        color: var(--text);
        opacity: .75;
        margin-bottom: 20px;
    }

    .wrapper-register .field {
        width: 100%;
        margin-bottom: 18px;
        box-sizing: border-box;
    }

    .wrapper-register label {
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
        color: var(--text);
        font-weight: 800;
    }

    .wrapper-register .required {
        font-size: 11px;
        color: #ef4444;
        margin-left: 6px;
        font-weight: 800;
    }

    .wrapper-register input[type="text"],
    .wrapper-register input[type="email"],
    .wrapper-register input[type="password"] {
        width: 100%;
        padding: 11px 12px;
        border-radius: 10px;
        border: 2px solid var(--border);
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        background: var(--bg);
        color: var(--text);
    }

    .wrapper-register input:focus {
        border-color: #60a5fa;
        background: rgba(96,165,250,0.08);
        transform: translateY(-2px);
        transition: 0.2s;
        box-shadow: 0 3px 8px rgba(96,165,250,0.25);
    }

    .wrapper-register .button {
        width: 100%;
        padding: 12px 0;
        margin-top: 6px;
        background: var(--text-blue);
        color: white;
        border: none;
        border-radius: 30px;
        font-weight: 800;
        font-size: 15px;
        cursor: pointer;
        box-shadow: 0 8px 18px rgba(96,165,250,0.35);
        transition: 0.15s;
    }

    .wrapper-register .button:hover {
        opacity: .95;
        transform: translateY(-1px);
    }

    .wrapper-register .bottom {
        margin-top: 15px;
        text-align: center;
        font-size: 13px;
        color: var(--text);
        opacity: .85;
        line-height: 1.9;
    }

    .wrapper-register .bottom a {
        color: var(--text-blue);
        text-decoration: none;
        font-weight: 800;
    }

    .wrapper-register .errors {
        background: rgba(239,68,68,0.12);
        border: 2px solid rgba(239,68,68,0.35);
        padding: 10px 12px;
        border-radius: 12px;
        color: #ef4444;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .wrapper-register .success {
        background: rgba(59,130,246,0.10);
        border: 2px solid rgba(59,130,246,0.25);
        padding: 10px 12px;
        border-radius: 12px;
        color: var(--text-blue);
        font-size: 13px;
        margin-bottom: 14px;
    }

    @media (max-width: 420px) {
        .wrapper-register {
            padding: 22px 18px 30px;
            border-radius: 18px;
        }
    }
</style>

<div class="wrapper-register">

    <div class="cat-image">
        <img src="{{ asset('images/アイコン.png') }}" alt="アイコン">
    </div>

    <h1>新規登録</h1>
    <p class="subtitle">アカウントを作成して「対抗」を楽しもう！</p>

    {{-- 成功 --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- エラー --}}
    @if ($errors->any())
        <div class="errors">
            <ul style="margin:0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ ログイン中なら登録は不要なので案内 --}}
    @auth
        <div class="success">
            すでにログインしています（{{ auth()->user()->name }}）<br>
            登録ではなくマイページから操作できます。
        </div>
        <div class="bottom">
            <a href="{{ route('profile') }}">→ マイページへ</a><br>
            <a href="{{ route('home') }}">← トップへ戻る</a>
        </div>
    @endauth

    {{-- ✅ 未ログインなら登録フォーム --}}
    @guest
        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="field">
                <label>ユーザー名 <span class="required">必須</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label>メールアドレス <span class="required">必須</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>

            <div class="field">
                <label>パスワード <span class="required">必須</span></label>
                <input type="password" name="password" required autocomplete="new-password">
            </div>

            <div class="field">
                <label>パスワード（確認） <span class="required">必須</span></label>
                <input type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button class="button" type="submit">登録する</button>
        </form>

        <div class="bottom">
            すでにアカウントがありますか？<br>
            <a href="{{ route('login') }}">→ ログインへ</a><br>
            <a href="{{ route('home') }}">← トップへ戻る</a>
        </div>
    @endguest

</div>

@endsection
