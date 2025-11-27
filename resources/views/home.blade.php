<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>好きな曲投稿サイト - トップ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            margin: 0;
            background-color: #f7fafc;
        }
        header {
            background-color: #1a202c;
            color: #fff;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .site-title {
            font-size: 20px;
            font-weight: bold;
        }
        header .nav-buttons a {
            color: #1a202c;
            background-color: #edf2f7;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            margin-left: 8px;
            font-size: 14px;
        }
        main {
            max-width: 1100px;
            margin: 24px auto;
            padding: 0 16px 24px;
        }
        .post-button-wrapper {
            text-align: center;
            margin-bottom: 24px;
        }
        .post-button-wrapper a {
            background-color: #3182ce;
            color: #fff;
            padding: 10px 20px;
            font-weight: bold;
            display: inline-block;
            border-radius: 9999px;
            text-decoration: none;
        }
        .post-button-wrapper a:hover {
            background-color: #2b6cb0;
        }
        .section {
            background-color: #fff;
            padding: 16px 20px;
            margin-bottom: 16px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .section h2 {
            font-size: 18px;
            margin-top: 0;
            border-left: 4px solid #3182ce;
            padding-left: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        thead {
            background-color: #edf2f7;
        }
        .label-genre {
            background-color: #ebf8ff;
            color: #2b6cb0;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 12px;
        }
        .muted {
            font-size: 13px;
            color: #718096;
        }
        .stars {
            color: gold;
            font-size: 16px;
        }
    </style>
</head>
<body>

<header>
    <div class="site-title">
        好きな曲シェアサイト
    </div>
    <div class="nav-buttons">
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('register') }}">新規登録</a>
    </div>
</header>

<main>

    {{-- 曲投稿ボタン --}}
    <div class="post-button-wrapper">
        <a href="{{ route('songs.create') }}">好きな曲を投稿する</a>
        <p class="muted">※1ユーザー3曲まで投稿できます（投稿処理側で制限）</p>
    </div>

    {{-- 今日の5つ星ランキング --}}
    <section class="section">
        <h2>本日の5つ星ランキング</h2>

        @if ($dailyRanking->isEmpty())
            <p class="muted">まだ本日の評価がありません。</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>順位</th>
                        <th>曲名</th>
                        <th>アーティスト</th>
                        <th>ジャンル</th>
                        <th>平均評価</th>
                        <th>今日の投票数</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailyRanking as $index => $song)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ $song->url }}" target="_blank">
                                    {{ $song->title }}
                                </a>
                            </td>
                            <td>{{ $song->artist }}</td>
                            <td>
                                @if($song->genre)
                                    <span class="label-genre">{{ $song->genre->name }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $avg = round($song->avg_rating ?? 0, 1);
                                    $fullStars = floor($avg);
                                @endphp
                                <span class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $fullStars ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <span class="muted">({{ $avg }} / 5)</span>
                            </td>
                            <td>{{ $song->today_vote_count }} 件</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    {{-- 最近投稿された曲 --}}
    <section class="section">
        <h2>最近投稿された曲</h2>

        @if ($recentSongs->isEmpty())
            <p class="muted">まだ曲が投稿されていません。</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>投稿日時</th>
                        <th>曲名</th>
                        <th>アーティスト</th>
                        <th>ジャンル</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentSongs as $song)
                        <tr>
                            <td>{{ $song->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ $song->url }}" target="_blank">
                                    {{ $song->title }}
                                </a>
                            </td>
                            <td>{{ $song->artist }}</td>
                            <td>
                                @if($song->genre)
                                    <span class="label-genre">{{ $song->genre->name }}</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

</main>

</body>
</html>
