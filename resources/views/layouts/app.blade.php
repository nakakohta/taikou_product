<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? '対抗 - Taikou' }}</title>

    <style>
        :root{
            --bg:#f5faff;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#d4e9ff;
            --text-blue:#3b82f6;
            --shadow: rgba(15, 23, 42, 0.08);
        }

        body{
            margin:0;
            font-family:"Zen Maru Gothic","Yu Gothic",sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        header{
            position: sticky;
            top: 0;
            z-index: 10;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding: 14px 20px;
            background: var(--card);
            border-bottom: 2px solid var(--border);
        }

        .wrapper{
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 20px 60px;
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
            min-width: 0;
        }
        .logo-img{
            width: 52px;
            height: 52px;
            border-radius: 14px;
            object-fit: cover;
            display:block;
            flex: 0 0 auto;
        }
        .logo-text{
            font-size: 26px;
            font-weight: 800;
            color: var(--text-blue);
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        img{ max-width: 100%; height: auto; }

        .user-area{
            display:flex;
            align-items:center;
            gap:10px;
            min-width: 0;
        }

        /* ✅ ヘッダーのアイコン枠（画像 or 文字） */
        .user-icon-wrap{
            width:34px;
            height:34px;
            border-radius:50%;
            border:2px solid var(--border);
            background: var(--bg);
            flex: 0 0 auto;
            overflow:hidden;
            position: relative;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .user-icon{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        /* ✅ 画像が無い/読めない時の「ユーザー名1文字」 */
        .user-initial{
            width:100%;
            height:100%;
            display:none; /* 通常は非表示 */
            align-items:center;
            justify-content:center;
            font-weight:900;
            font-size:14px;
            color:#fff;
            background: var(--text-blue);
            letter-spacing: 0.5px;
        }
        .user-initial.show{ display:flex; }

        .user-name{
            font-size:14px;
            font-weight:800;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
        }

        .logout-btn{
            border:none;
            background:transparent;
            cursor:pointer;
            color: var(--text-blue);
            font-weight:800;
            margin-left: 6px;
            white-space: nowrap;
        }

        nav a{
            color: var(--text-blue);
            font-weight: 800;
            text-decoration:none;
        }
        nav a:hover{ text-decoration: underline; }

        /* ✅ スマホ最適化：ヘッダーが詰まるのを防ぐ */
        @media (max-width: 520px){
            .logo-text{ font-size: 20px; }
            .user-name{ display:none; } /* 小画面では名前を隠して崩れ防止 */
        }
    </style>
</head>

<body>
<header>
    <a href="{{ route('home') }}" class="logo-area">
        <img src="{{ asset('images/アイコン.png') }}" class="logo-img" alt="logo">
        <div class="logo-text">対抗 - Taikou</div>
    </a>

    <nav class="user-area">
        @auth
            @php
                $u = Auth::user();
                $initial = mb_substr($u->name ?? 'U', 0, 1);
            @endphp

            <a href="{{ route('profile') }}"
               style="display:flex;align-items:center;gap:10px;text-decoration:none;min-width:0;">
                <span class="user-icon-wrap">
                    {{-- ✅ 常に icon_url を使う（外部URLでもローカルでもOK） --}}
                    <img
                        src="{{ $u->icon_url }}"
                        class="user-icon"
                        alt="icon"
                        onerror="this.style.display='none'; this.nextElementSibling.classList.add('show');"
                    >
                    <span class="user-initial">{{ $initial }}</span>
                </span>

                <span class="user-name">{{ $u->name }}</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">ログアウト</button>
            </form>
        @else
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register.show') }}">新規登録</a>
        @endauth
    </nav>
</header>

<div class="wrapper">
    @yield('content')
</div>
</body>
</html>
