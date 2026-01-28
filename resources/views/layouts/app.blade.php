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
            --soft:#eef6ff;
        }

        *{ box-sizing:border-box; }

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

        /* ロゴ */
        .logo-area{
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
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
        }

        /* 全画像の暴走防止（ロゴは固定済み） */
        img{ max-width: 100%; height: auto; }

        /* 右側 */
        .user-area{
            display:flex;
            align-items:center;
            gap:10px;
        }
        .user-icon{
            width:34px;
            height:34px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid var(--border);
            flex: 0 0 auto;
            background: var(--bg);
        }
        .user-name{
            font-size:14px;
            font-weight:800;
            color: var(--text);
        }
        .logout-btn{
            border:none;
            background:transparent;
            cursor:pointer;
            color: var(--text-blue);
            font-weight:800;
            margin-left: 6px;
        }

        nav a{
            color: var(--text-blue);
            font-weight: 800;
            text-decoration:none;
        }
        nav a:hover{ text-decoration: underline; }

        /* 共通フォーム */
        input, textarea, select, button{ font-family: inherit; }
        input, textarea, select{
            color: var(--text);
            background: var(--soft);
            border: 2px solid var(--border);
            outline: none;
        }
        input::placeholder, textarea::placeholder{ color: var(--muted); }

        .muted{ color: var(--muted); }

        .card{
            background: var(--card);
            border: 2px solid var(--border);
            box-shadow: 0 12px 30px var(--shadow);
            border-radius: 22px;
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
            <a href="{{ route('profile') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <img
                    src="{{ Auth::user()->icon ? asset('storage/'.Auth::user()->icon) : asset('images/default_icon.png') }}"
                    class="user-icon"
                    alt="icon"
                >
                <span class="user-name">{{ Auth::user()->name }}</span>
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
