<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ユーザープロフィール - サイト名未定</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f9fafb;
                color: #333;
            }
            .song-card {
                background-color: white;
                transition: transform 0.2s, box-shadow 0.2s;
                cursor: pointer;
            }
            .song-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="antialiased">

        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="text-xl font-bold text-gray-800">
                    <span class="text-[#FF2D20]">サイト名未定</span>
                </div>
                <nav>
                    <a href="/" class="text-sm text-gray-500 hover:text-[#FF2D20]">ログアウト</a>
                </nav>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-4 py-10 sm:px-6">

            <div class="flex flex-row items-center gap-6 mb-12">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-300 rounded-lg border-4 border-white shadow-md flex items-center justify-center text-gray-500">
                        <span class="text-sm">No Image</span>
                    </div>
                </div>
                
                <div class="flex-grow">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        テスト 太郎
                    </h1>
                    <p class="text-gray-500 text-sm mb-3">@music_lover_01</p>
                    <div class="text-sm text-gray-600 leading-relaxed mb-4">
                        ロックとジャズが好きです。週末に曲を作って投稿しています。<br>
                        コラボ募集中！
                    </div>
                    <button class="bg-[#FF2D20] text-white px-6 py-1.5 rounded-full text-sm font-bold shadow hover:bg-red-600 transition">
                        フォローする
                    </button>
                </div>
            </div>

            <section class="mb-12">
                <div class="flex items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[#FF2D20] pl-3">
                        My ベストソング
                    </h2>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6">
                    <div class="song-card rounded-lg overflow-hidden shadow-sm border border-gray-100 group">
                        <div class="aspect-[3/4] bg-gray-200 relative flex items-center justify-center">
                            <span class="text-gray-400 text-xs">Artwork 1</span>
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center transition">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg opacity-80">
                                    <span class="text-[#FF2D20] ml-1">▶</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <h3 class="font-bold text-sm text-gray-800 truncate">深夜のHighway</h3>
                            <p class="text-xs text-gray-500 mt-1">2025.11.20</p>
                        </div>
                    </div>

                    <div class="song-card rounded-lg overflow-hidden shadow-sm border border-gray-100 group">
                        <div class="aspect-[3/4] bg-gray-800 relative flex items-center justify-center">
                            <span class="text-gray-500 text-xs">Artwork 2</span>
                             <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center transition">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg opacity-80">
                                    <span class="text-[#FF2D20] ml-1">▶</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <h3 class="font-bold text-sm text-gray-800 truncate">Blue Rain</h3>
                            <p class="text-xs text-gray-500 mt-1">2025.10.05</p>
                        </div>
                    </div>

                    <div class="song-card rounded-lg overflow-hidden shadow-sm border border-gray-100 group">
                        <div class="aspect-[3/4] bg-gray-200 relative flex items-center justify-center">
                            <span class="text-gray-400 text-xs">Artwork 3</span>
                             <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center transition">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg opacity-80">
                                    <span class="text-[#FF2D20] ml-1">▶</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 text-center">
                            <h3 class="font-bold text-sm text-gray-800 truncate">朝焼けのコーヒー</h3>
                            <p class="text-xs text-gray-500 mt-1">2025.08.12</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-full">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                        好きなジャンル
                    </h3>
                    <div class="flex flex-wrap gap-2 content-start">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">J-POP</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">Alternative Rock</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">Lo-Fi HipHop</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">Jazz</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">R&B</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-full">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                        好きな曲の集計
                    </h3>
                    <div class="space-y-5">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-bold text-gray-700">1. Pretender</span>
                                <span class="text-xs text-gray-500">124回</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-[#FF2D20] h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-bold text-gray-700">2. 怪獣の花唄</span>
                                <span class="text-xs text-gray-500">98回</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-[#FF2D20] h-2 rounded-full opacity-80" style="width: 70%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-bold text-gray-700">3. アイドル</span>
                                <span class="text-xs text-gray-500">85回</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-[#FF2D20] h-2 rounded-full opacity-60" style="width: 60%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-bold text-gray-700">4. Marigold</span>
                                <span class="text-xs text-gray-500">54回</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-[#FF2D20] h-2 rounded-full opacity-40" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </body>
</html>