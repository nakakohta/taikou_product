<!DOCTYPE html>
<html lang="ja" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <title>テーマ設定 | 対抗 - Taikou</title>

    <style>
        :root {
            --bg: #f0f6ff;
            --card-bg: #ffffff;
            --text: #1e293b;
            --blue: #2563eb;
            --border: #d4e9ff;
        }

        /* ⭐ ダークテーマ */
        [data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --blue: #60a5fa;
            --border: #334155;
        }

        body {
            background: var(--bg);
            font-family: "Zen Maru Gothic", sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text);
        }

        header {
            background: var(--card-bg);
            padding: 16px 24px;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: var(--blue);
        }

        .wrapper {
            max-width: 680px;
            margin: 50px auto;
            padding: 20px;
        }

        .card {
            background: var(--card-bg);
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            border: 2px solid var(--border);
            text-align: center;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            color: var(--blue);
        }

        .theme-options {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
        }

        .option {
            width: 130px;
            padding: 14px;
            border-radius: 12px;
            border: 2px solid var(--border);
            background: var(--card-bg);
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: var(--text);
            transition: 0.2s;
        }

        .option:hover {
            background: var(--border);
        }

        .btn {
            margin-top: 20px;
            padding: 14px 34px;
            background: var(--blue);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(59,130,246,0.3);
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            background: #1d4ed8;
        }

    </style>
</head>

<body>

<header>
    <img src="{{ asset('images/アイコン.png') }}" class="logo-img">
    <div class="logo-text">テーマ設定</div>
</header>


<div class="wrapper">

    <div class="card">

        <div class="title">テーマを選択してください</div>

        <form action="{{ route('theme.change') }}" method="POST">
            @csrf

            <div class="theme-options">

                <!-- Light -->
                <label>
                    <input type="radio" name="theme" value="light"
                        style="display:none;"
                        {{ session('theme', 'light') === 'light' ? 'checked' : '' }}>
                    <div class="option">☀️ ライト</div>
                </label>

                <!-- Dark -->
                <label>
                    <input type="radio" name="theme" value="dark"
                        style="display:none;"
                        {{ session('theme') === 'dark' ? 'checked' : '' }}>
                    <div class="option">🌙 ダーク</div>
                </label>

            </div>

            <button class="btn" type="submit">テーマを変更する</button>
        </form>

    </div>

</div>

</body>
</html>
