@extends('layouts.app')

@section('content')

<style>
    .wrapper-login {
        width: 100%;
        max-width: 520px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 20px;
        padding: 28px 30px 36px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        border: 2px solid #d4e9ff;
        box-sizing: border-box;
    }

    .wrapper-login .cat-image {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .wrapper-login .cat-image img {
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

    .wrapper-login h1 {
        font-size: 20px;
        text-align: center;
        margin: 6px 0 10px;
        color: #3b82f6;
        font-weight: 700;
    }

    .wrapper-login .subtitle {
        font-size: 13px;
        text-align: center;
        color: #6b7280;
        margin-bottom: 20px;
        white-space: nowrap;
        overflow: hidden;
    }

    .wrapper-login .field {
        width: 100%;
        margin-bottom: 18px;
        box-sizing: border-box;
    }

    .wrapper-login label {
        font-size: 13px;
        margin-bottom: 5px;
        display: block;
        color: #374151;
        font-weight: 700;
    }

    .wrapper-login .required {
        font-size: 11px;
        color: #ef4444;
        margin-left: 4px;
        font-weight: 700;
    }

    .wrapper-login input[type="email"],
    .wrapper-login input[type="password"] {
        width: 100%;
        padding: 11px 12px;
        border-radius: 10px;
        border: 2px solid #cfe5ff;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
        background: #fff;
    }

    .wrapper-login input:focus {
        border-color: #60a5fa;
        background: #f0f8ff;
        transform: translateY(-2px);
        transition: 0.2s;
        box-shadow: 0 3px 8px rgba(96,165,250,0.25);
    }

    .wrapper-login .row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 4px;
    }

    .wrapper-login .remember {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #374151;
        user-select: none;
    }

    .wrapper-login .remember input {
        width: 16px;
        height: 16px;
        accent-color: #60a5fa;
    }

    .wrapper-login .button {
        width: 100%;
        padding: 12px 0;
        margin-top: 14px;
        background: #60a5fa;
        color: white;
        border: none;
        border-radius: 30px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        box-shadow: 0 8px 18px rgba(96,165,250,0.35);
        transition: 0.15s;
    }

    .wrapper-login .button:hover {
        background: #3b82f6;
        transform: translateY(-1px);
    }

    .wrapper-login .bottom {
        margin-top: 15px;
        text-align: center;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.9;
    }

    .wrapper-login .bottom a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 700;
    }

    .wrapper-login .errors {
        background: #ffe5e5;
        border: 2px solid #ffb5b5;
        padding: 10px 12px;
        border-radius: 12px;
        color: #b91c1c;
        font-size: 13px;
        margin-bottom: 14px;
    }

    .wrapper-login .success {
        background: #e7f7ff;
        border: 2px solid #bfe8ff;
        padding: 10px 12px;
        border-radius: 12px;
        color: #0369a1;
        font-size: 13px;
        margin-bottom: 14px;
    }

    @media (max-width: 420px) {
        .wrapper-login { padding: 22px 18px 30px; border-radius: 18px; }
        .wrapper-login .subtitle { white-space: normal; }
    }
</style>

<div class="wrapper-login">

    <div class="cat-image">
        <img src="{{ asset('images/アイコン.png') }}" alt="アイコン">
    </div>

    <h1>ログイン</h1>
    <p class="subtitle">音楽共有サイト「対抗」を楽しむためにログインします。</p>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul style="margin:0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="field">
            <label>メールアドレス <span class="required">必須</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
        </div>

        <div class="field">
            <label>パスワード <span class="required">必須</span></label>
            <input type="password" name="password" required autocomplete="current-password">
        </div>

        <div class="row">
            <label class="remember">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                ログイン状態を保存
            </label>
        </div>

        <button class="button" type="submit">ログインする</button>
    </form>

    <div class="bottom">
        まだアカウントがありませんか？<br>
        <a href="{{ route('register.show') }}">新規登録へ</a><br>
        <a href="{{ route('home') }}">← トップへ戻る</a>
    </div>

</div>

@endsection
