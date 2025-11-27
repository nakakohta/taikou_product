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
            width: 280px;
            height: 280px;
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

        /* コメント表示 */
        .comment-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #3b82f6;
        }

        .comment-box {
            border: 2px solid #d4e9ff;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            background: #ffffff;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .comment-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #d4e9ff;
        }

        .comment-name {
            font-size: 16px;
            font-weight: bold;
            color: #374151;
        }

        .comment-text {
            font-size: 15px;
            color: #374151;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- 上部：曲情報 -->
    <div class="top-area">

        <div class="left-thumb">
            <img src="{{ asset('storage/' . $music->thumbnail) }}" alt="サムネ">
        </div>

        <div class="right-info">
            <div class="title">{{ $music->title }}</div>

            <div class="desc-box">
                {{ $music->description }}
            </div>

            @php
                $avg = $reviews->avg('rating') ?? 0;
            @endphp

            <div class="review-stars">
                @for($i=1; $i<=5; $i++)
                    @if($i <= $avg)
                        ★
                    @else
                        <span style="color:#d1d5db;">★</span>
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
    <div class="comment-title">コメント一覧</div>

    @foreach ($comments as $comment)
        <div class="comment-box">

            <div class="comment-header">

                <!-- アイコン（ユーザープロフィールから） -->
                <img src="{{ asset('storage/icons/' . ($comment->user->icon ?? 'default_icon.png')) }}"
                     class="comment-icon">

                <!-- 名前（ユーザープロフィールから） -->
                <div class="comment-name">
                    {{ $comment->user->name }}
                </div>

            </div>

            <div class="comment-text">
                {{ $comment->comment }}
            </div>

        </div>
    @endforeach

</div>

</body>
</html>
