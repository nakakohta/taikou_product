<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ログイン - Laravel</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f3f4f6; /* 少し明るいグレー */
            }
            
            /* Laravel公式の赤色: #FF2D20 */
            
            /* 入力フォームのスタイル */
            .laravel-input {
                border: 1px solid #d1d5db; /* 薄いグレー */
                background-color: #ffffff;
                color: #1f2937;
                transition: all .2s;
            }
            .laravel-input:focus {
                border-color: #FF2D20; /* フォーカス時にLaravelレッド */
                box-shadow: 0 0 0 1px #FF2D20;
                outline: none;
            }

            /* ボタンのスタイル */
            .laravel-button {
                background-color: #FF2D20; /* Laravelレッド */
                border: 1px solid #FF2D20;
                color: #fff;
                transition: background-color .2s ease-in-out;
            }
            .laravel-button:hover {
                background-color: #e02418; /* ホバー時は少し濃い赤 */
                border-color: #e02418;
            }
        </style>
    </head>
    <body class="antialiased text-gray-600">
        
        <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0 pb-20">
            
            <div class="mb-6">
                <h1 class="text-4xl font-bold tracking-tight text-gray-800">
                    <span class="text-[#FF2D20]">Laravel</span>
                </h1>
            </div>

            <div class="w-full max-w-[320px] p-6 bg-white shadow-md rounded-lg border-t-4 border-[#FF2D20]">
                
                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-gray-700" for="email">
                            メールアドレス
                        </label>
                        <input class="laravel-input w-full p-2 rounded text-base" id="email" type="email" name="email" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2 text-gray-700" for="password">
                            パスワード
                        </label>
                        <input class="laravel-input w-full p-2 rounded text-base" id="password" type="password" name="password" required>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <label class="flex items-center text-sm cursor-pointer hover:text-gray-900">
                            <input type="checkbox" class="mr-2 rounded border-gray-300 text-[#FF2D20] focus:ring-[#FF2D20] focus:ring-opacity-50" name="remember">
                            <span class="text-xs">ログイン状態を保存</span>
                        </label>

                        <button class="laravel-button font-bold py-2 px-6 rounded shadow-sm text-sm" type="submit">
                            ログイン
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center space-y-2">
                <div>
                    <a href="#" class="text-xs text-gray-500 hover:text-[#FF2D20] underline transition">
                        パスワードをお忘れですか？
                    </a>
                </div>
                <div>
                    <a href="#" class="text-xs text-gray-500 hover:text-[#FF2D20] no-underline transition">
                        ← サイトへ戻る
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
{{-- ログインページ --}}