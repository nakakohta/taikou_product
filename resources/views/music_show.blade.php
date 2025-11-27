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
            width: 260px;
            height: 260px;
            background: #eef6ff;
            border-radius: 16px;
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
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #3b82f6;
        }

        .comment-box {
            border: 2px solid #d4e9ff;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .comment-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #d4e9ff;
        }

        .comment-name {
            font-weight: bold;
        }

        .comment-text {
            margin-top: 8px;
            font-size: 15px;
            color: #374151;
        }

        .comment-form {
            background: #f0f8ff;
            border: 2px solid #d4e9ff;
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .comment-submit {
            width: 100%;
            padding: 12px;
            background: #60a5fa;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="top-area">

        <div class="left-thumb">
            <img src="{{ asset('storage/' . $music->thumbnail) }}" alt="サムネ">
        </div>

        <div class="right-info">
            <div class="title">{{ $music->title }}</div>

            <div class="desc-box">
                {{ $music->description }}
            </div>

            @php $avg = $reviews->avg('rating') ?? 0; @endphp

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

    <!-- コメント投稿フォーム -->
    <div class="comment-title">コメントを書く</div>

    @auth
    <form action="{{ route('comment.store', $music->id) }}" method="POST" class="comment-form">
        @csrf
        <textarea name="comment" rows="4" required placeholder="コメントを入力"></textarea>
        <button type="submit" class="comment-submit">投稿する</button>
    </form>
    @else
        <p>コメントするには <a href="/login">ログイン</a> が必要です。</p>
    @endauth

    <!-- コメント一覧 -->
    <div class="comment-title">コメント一覧</div>

    @foreach ($comments as $comment)
        <div class="comment-box">
            <div class="comment-header">

                <!-- アイコン -->
                @if ($comment->user && $comment->user->icon)
                    <img src="{{ asset('storage/icons/' . $comment->user->icon) }}" class="comment-icon">
                @else
                    <img src="{{ asset('images/default_icon.png') }}" class="comment-icon">
                @endif

                <div class="comment-name">
                    {{ $comment->user->name ?? '未登録ユーザー' }}
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
