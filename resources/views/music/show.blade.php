<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $music->title }}</title>

    <style>
        body {
            background: #f5faff;
            font-family: "Zen Maru Gothic", sans-serif;
            margin: 0;
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            border: 2px solid #d4e9ff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .top-area {
            display: flex;
            gap: 40px;
        }

        .left-thumb {
            width: 380px;
            height: 380px;
            background: #eef6ff;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border: 2px solid #d4e9ff;
        }

        .left-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .right-info {
            flex: 1;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #3b82f6;
        }

        .desc-box {
            background: #f0f8ff;
            padding: 15px;
            border-radius: 12px;
            border: 2px solid #d4e9ff;
            margin-bottom: 20px;
        }

        .review-stars {
            font-size: 30px;
            color: #fbbf24;
        }

        .review-count {
            margin-top: 6px;
            font-size: 14px;
            color: #6b7280;
        }

        hr {
            margin: 30px 0;
            border: none;
            border-top: 2px solid #d4e9ff;
        }

        .comment-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #3b82f6;
        }

        .comment-box {
            border: 2px solid #d4e9ff;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .comment-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-stars {
            font-size: 22px;
            color: #fbbf24;
        }

        .comment-text {
            font-size: 15px;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="top-area">

        <!-- 左：サムネ -->
        <div class="left-thumb">
            <img src="{{ asset('storage/' . $music->thumbnail) }}" alt="サムネ">
        </div>

        <!-- 右：情報 -->
        <div class="right-info">
            <div class="title">{{ $music->title }}</div>

            <div class="desc-box">
                {{ $music->description }}
            </div>

            <!-- ★レビュー平均を動的表示 -->
            @php
                $avg = $reviews->avg('rating') ?? 0;
            @endphp

            <div class="review-stars">
                @for($i=1; $i<=5; $i++)
                    @if($i <= $avg)
                        ★
                    @else
                        <span style="color: #d1d5db;">★</span>
                    @endif
                @endfor
            </div>

            <div class="review-count">
                レビュー {{ $reviews->count() }}件
            </div>

        </div>
    </div>

    <hr>

    <!-- コメント一覧 -->
    <div class="comment-title">コメント</div>

    @foreach ($comments as $comment)
        <div class="comment-box">
            <div class="comment-name">
                {{ $comment->name }}　

                <!-- コメントごとの星評価 -->
                <span class="comment-stars">
                    @for ($i=1; $i<=5; $i++)
                        @if ($i <= $comment->rating)
                            ★
                        @else
                            <span style="color:#d1d5db;">★</span>
                        @endif
                    @endfor
                </span>
            </div>

            <div class="comment-text">
                {{ $comment->comment ?? $comment->content }}
            </div>
        </div>
    @endforeach

</div>

</body>
</html>
