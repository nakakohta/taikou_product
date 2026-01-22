<!DOCTYPE html>
<html lang="ja" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <title>対抗 | ホーム</title>

    <style>
        :root {
            --bg: #f0f6ff;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-blue: #2563eb;
            --border: #d4e9ff;
        }

        /* ダークモード */
        [data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --text-blue: #60a5fa;
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
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            height: 56px;
            width: 56px;
            border-radius: 12px;
            object-fit: cover;
        }

        .logo-text {
            font-size: 26px;
            font-weight: bold;
            color: var(--text-blue);
        }

        nav a {
            margin-left: 20px;
            color: var(--text-blue);
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
        }

        .wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .btn-post {
            display: inline-block;
            padding: 14px 34px;
            background: var(--text-blue);
            border-radius: 28px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 22px;
            font-weight: bold;
            color: var(--text-blue);
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ranking-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 14px;
        }

        .rank-badge {
            width: 52px;
            height: 52px;
            background: #60a5fa;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .song-info {
            flex: 1;
        }

        .song-title {
            font-size: 18px;
            font-weight: bold;
        }

        .genre-tag {
            background: var(--border);
            padding: 4px 10px;
            border-radius: 10px;
            font-size: 12px;
        }

        .song-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 18px;
        }

        .song-card {
            background: var(--card-bg);
            border: 2px solid var(--border);
            padding: 14px;
            border-radius: 14px;
        }

        .song-link {
            color: var(--text-blue);
            font-size: 14px;
        }
    </style>
</head>

<body>

<header>
    <div class="logo-area">
        <img src="{{ asset('images/アイコン.png') }}" class="logo-img">
        <div class="logo-text">対抗 - Taikou</div>
    </div>

    <nav>
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('register.show') }}">新規登録</a>
    </nav>
</header>

<div class="wrapper">

    <a href="{{ route('songs.create') }}" class="btn-post">＋ 曲を投稿する</a>

    <!-- ランキング -->
    <h2 class="section-title">
        <img src="{{ asset('images/トロフィー.png') }}" style="height:28px;">
        今日のランキング TOP5
    </h2>

    <!-- @foreach ($dailyRanking->take(5) as $index => $song)
        <div class="ranking-card">
            <div class="rank-badge">{{ $index + 1 }}</div>

            <div class="song-info">
                <div class="song-title">{{ $song->title }}</div>
                <div>by {{ $song->artist }}</div>
                <div class="genre-tag">{{ $song->genre->name }}</div>
            </div>

            <a href="{{ route('music.show', $song->id) }}" class="song-link">▶ 曲ページへ</a>
        </div>
    @endforeach -->

    <!-- 最近投稿 -->
    <h2 class="section-title">
        <img src="{{ asset('images/ニューアイコン.png') }}" style="height:26px;">
        最近投稿された曲
    </h2>

    <div class="song-list">
        @foreach ($recentSongs as $song)
            <div class="song-card">
                <span class="genre-tag">{{ $song->genre->name }}</span>
                <div class="song-title">{{ $song->title }}</div>
                <div>by {{ $song->artist }}</div>
                <a href="{{ route('music.show', $song->id) }}" class="song-link">▶ 曲ページへ</a>
            </div>
        @endforeach
    </div>

</div>

</body>
</html>
