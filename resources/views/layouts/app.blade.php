<!DOCTYPE html>
<html lang="ja" data-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? '対抗 - Taikou' }}</title>

    <style>
        /* あなたが作ったCSS（省略） */
    </style>
</head>

<body>

<header>
    <div class="logo-area">
        <img src="{{ asset('images/アイコン.png') }}" class="logo-img">
        <div class="logo-text">対抗 - Taikou</div>
    </div>

    <nav>
        <a href="/theme" class="theme-btn">🌙/☀️</a>
        <a href="{{ route('login') }}">ログイン</a>
        <a href="{{ route('register.show') }}">新規登録</a>
    </nav>
</header>

<div class="wrapper">
    @yield('content')   {{-- ← これが正しい --}}
</div>

</body>
</html>
