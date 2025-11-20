<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $music->title }} | 対抗（TAIKOU）</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Zen Maru Gothic", "Yu Gothic", sans-serif;
            background: #f5faff;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .wrapper {
            width: 100%;
            max-width: 800px;
            background: #ffffff;
            border-radius: 20px;
            padding: 30px 36px 50px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border: 2px solid #d4e9ff;
            box-sizing: border-box;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        /* サムネイル */
        .thumbnail {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
            display: block;
            border-radius: 16px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.1);
            border: 3px solid #b8ddff;
        }

        /* 曲タイトル */
        .title {
            margin-top: 20px;
            font-size: 26px;
            font-weight: 700;
            color: #3b82f6;
            text-align: center;
        }

        /* 概要欄 */
        .description-box {
            margin-top: 25px;
            background: #f9fcff;
            border: 2px solid #d4e9ff;
            padding: 18px;
            border-radius: 12px;
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
        }

        /* レビュー セクション */
        .review-section {
            margin-top: 25px;
        }

        .stars {
            font-size: 26px;
            color: #fbbf24;
        }

        .review-count {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        /* コメント欄 */
        .comment-card {
            margin-top: 20px;
            background: #ffffff;
            border: 2px solid #d4e9ff;
            padding: 16px;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        .comment-header {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .user-icon {
            width: 40px;
            height: 40px;
            background: #dbeaff;
            border-radius: 50%;
            margin-right: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #3b82f6;
        }

        .username {
            font-size: 15px;
            font-weight: bold;
            color: #374151;
        }

        .comment-stars {
            margin-left: auto;
            color: #fbbf24;
        }

        .comment-text {
            margin-top: 8px;
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
        }
    </style>
</head>

<body>
<div class="wrapper">

    <!-- サムネイル -->
    <img src="{{ asset('uploads/' . $music->thumbnail) }}" alt="サムネ" class="thumbnail">

    <!-- 曲タイトル -->
    <div class="title">{{ $music->title }}</div>

    <!-- 概要欄 -->
    <div class="description-box">
        {{ $music->description }}
    </div>

    <!-- レビュー -->
    <div class="review-section">
        <div class="stars">★★★★★</div>
        <div class="review-count">レビュー {{ count($reviews) }}件</div>
    </div>

    <!-- コメント欄 -->
    @foreach($comments as $comment)
        <div class="comment-card">
            <div class="comment-header">
                <div class="user-icon">にゃ</div>
                <div class="username">{{ $comment->username }}</div>
                <div class="comment-stars">★★★★★</div>
            </div>
            <div class="comment-text">{{ $comment->text }}</div>
        </div>
    @endforeach

</div>
</body>
</html>
