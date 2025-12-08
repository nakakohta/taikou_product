<x-app-layout>

<style>
/* =====================================
   ログインページ（ライト / ダーク対応）
===================================== */

.login-wrapper {
    max-width: 480px;
    margin: 40px auto;
    background: var(--card-bg);
    border-radius: 20px;
    padding: 32px 30px 40px;
    border: 2px solid var(--border);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

/* にゃんこ画像 */
.cat-image {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}

.cat-image img {
    width: 130px;
    border-radius: 20px;
    animation: fuwafuwa 3s ease-in-out infinite;
}

@keyframes fuwafuwa {
    0% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0); }
}

h1 {
    font-size: 24px;
    text-align: center;
    margin: 6px 0 10px;
    font-weight: bold;
    color: var(--text-blue);
}

.subtitle {
    font-size: 14px;
    text-align: center;
    color: var(--text);
    margin-bottom: 24px;
}

.field {
    width: 100%;
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 14px;
    margin-bottom: 6px;
    font-weight: bold;
    color: var(--text-blue);
}

input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 2px solid var(--border);
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    box-sizing: border-box;
}

input:focus {
    border-color: var(--text-blue);
    background: rgba(96,165,250,0.1);
}

.button {
    width: 100%;
    padding: 14px 0;
    background: var(--text-blue);
    color: white;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 6px 16px rgba(96,165,250,0.3);
}

.button:hover {
    background: #1d4ed8;
}

.bottom {
    margin-top: 16px;
    text-align: center;
    font-size: 14px;
}

.bottom a {
    color: var(--text-blue);
    text-decoration: none;
}

/* スマホ対応 */
@media (max-width: 480px) {
    .login-wrapper {
        padding: 24px 20px 32px;
    }
}
</style>


<div class="login-wrapper">

    <div class="cat-image">
        <img src="{{ asset('images/cat.png') }}" alt="にゃんこ">
    </div>

    <h1>ログイン</h1>
    <p class="subtitle">アカウントにログインして音楽を楽しみましょう。</p>

    <!-- エラー表示 -->
    @if ($errors->any())
        <div style="background:#ffe5e5; border:2px solid #ffb5b5; padding:10px; border-radius:10px; margin-bottom:15px; color:#b91c1c;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>・{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label>メールアドレス</label>
            <input type="email" name="email" required value="{{ old('email') }}">
        </div>

        <div class="field">
            <label>パスワード</label>
            <input type="password" name="password" required>
        </div>

        <button class="button" type="submit">ログインする</button>
    </form>

    <p class="bottom">
        アカウントがありませんか？
        <a href="{{ route('register.show') }}">新規登録はこちら</a>
    </p>

</div>

</x-app-layout>
