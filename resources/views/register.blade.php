<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録 | 対抗（TAIKOU）</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Zen Maru Gothic", "Yu Gothic", sans-serif;
            background: #f5faff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* ←←← wrapper を A：520px に拡張 */
        .wrapper {
            width: 100%;
            max-width: 520px;  /* ←ここを 430 → 520 に変更 */
            background: #ffffff;
            border-radius: 20px;
            padding: 28px 30px 36px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border: 2px solid #d4e9ff;
            box-sizing: border-box;
        }

        /* にゃんこ画像 */
        .cat-image {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .cat-image img {
            width: 150px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            animation: fuwafuwa 3s ease-in-out infinite;
        }

        /* ふわふわアニメーション */
        @keyframes fuwafuwa {
            0% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0); }
        }

        h1 {
            font-size: 20px;
            text-align: center;
            margin: 6px 0 10px;
            color: #3b82f6;
            font-weight: 700;
        }

        /* サブタイトル：改行防止済み */
        .subtitle {
            font-size: 13px;
            text-align: center;
            color: #6b7280;
            margin-bottom: 20px;
            white-space: nowrap;
            overflow: hidden;
        }

        /* 入力欄まわり（ズレ修正） */
        .field {
            width: 100%;
            margin-bottom: 18px;
            box-sizing: border-box;
        }

        label {
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
            color: #374151;
        }

        .required {
            font-size: 11px;
            color: #ef4444;
            margin-left: 4px;
        }

        input {
            width: 100%;
            padding: 11px 12px;
            border-radius: 10px;
            border: 2px solid #cfe5ff;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #60a5fa;
            background: #f0f8ff;
            transform: translateY(-2px);
            transition: 0.2s;
            box-shadow: 0 3px 8px rgba(96,165,250,0.25);
        }

        .button {
            width: 100%;
            padding: 12px 0;
            margin-top: 5px;
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

        .button:hover {
            background: #3b82f6;
            transform: translateY(-1px);
        }

        .bottom {
            margin-top: 15px;
            text-align: center;
            font-size: 13px;
        }

        .bottom a {
            color: #3b82f6;
            text-decoration: none;
        }

        .errors {
            background: #ffe5e5;
            border: 2px solid #ffb5b5;
            padding: 10px;
            border-radius: 10px;
            color: #b91c1c;
            font-size: 13px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>

<div class="wrapper">

    <div class="cat-image">
        <img src="{{ asset('images/cat.png') }}" alt="にゃんこ">
    </div>

    <h1>新規登録</h1>

    <p class="subtitle">音楽共有サイト「対抗」を楽しむためのアカウントを作成します。</p>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        
        <div class="field">
            <label>ユーザー名 <span class="required">必須</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="field">
            <label>メールアドレス <span class="required">必須</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="field">
            <label>パスワード <span class="required">必須</span></label>
            <input type="password" name="password" required>
        </div>

        <div class="field">
            <label>パスワード（確認） <span class="required">必須</span></label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button class="button" type="submit">アカウントを作成する</button>
    </form>

    <p class="bottom">
        すでにアカウントがありますか？  
        <a href="{{ url('/') }}">トップへ戻る</a>
    </p>

</div>

</body>
</html>
