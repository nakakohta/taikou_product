@extends('layouts.app')

@section('content')
{{-- Tailwindを使う前提（layouts.app側でTailwindを読み込んでない場合は下の注意を見てください） --}}

<style>
    /* Tailwind + ちょい補助（カードhoverなど） */
    .song-card { transition: transform .2s, box-shadow .2s; cursor: pointer; }
    .song-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,.12); }
</style>

<div class="max-w-3xl mx-auto px-4 py-10 sm:px-6">

    {{-- ✅ 成功メッセージ --}}
    @if(session('success'))
        <div class="mb-6 p-3 rounded-xl border-2 border-sky-200 bg-sky-50 text-sky-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ エラー --}}
    @if($errors->any())
        <div class="mb-6 p-3 rounded-xl border-2 border-red-200 bg-red-50 text-red-700 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ✅ プロフィール上部（HTML版のデザインをLaravelのユーザー情報に置き換え） --}}
    <div class="flex flex-row items-center gap-6 mb-12">

        <div class="flex-shrink-0">
            <img
                src="{{ auth()->user()->icon
                        ? asset('storage/'.auth()->user()->icon)
                        : asset('images/default_icon.png') }}"
                class="w-24 h-24 sm:w-32 sm:h-32 rounded-lg border-4 border-white shadow-md object-cover bg-gray-200"
                alt="icon"
            >
        </div>

        <div class="flex-grow">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                {{ auth()->user()->name }}
            </h1>

            <p class="text-gray-500 text-sm mb-3">
                {{ auth()->user()->email }}
            </p>

            <div class="text-sm text-gray-600 leading-relaxed mb-4">
                ログイン中 ✅
            </div>

            {{-- フォロー機能はまだならボタンは無効化（見た目だけ） --}}
            <button type="button"
                class="bg-[#FF2D20] text-white px-6 py-1.5 rounded-full text-sm font-bold shadow opacity-60 cursor-not-allowed">
                フォローする（準備中）
            </button>
        </div>
    </div>

    {{-- ✅ My ベストソング（いまはダミー表示のまま。DB化するなら次でやる） --}}
    <section class="mb-12">
        <div class="flex items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800 border-l-4 border-[#FF2D20] pl-3">
                My ベストソング
            </h2>
        </div>

        <div class="grid grid-cols-3 gap-4 sm:gap-6">
            @for($i=1; $i<=3; $i++)
                <div class="song-card rounded-lg overflow-hidden shadow-sm border border-gray-100 group">
                    <div class="aspect-[3/4] bg-gray-200 relative flex items-center justify-center">
                        <span class="text-gray-400 text-xs">Artwork {{ $i }}</span>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 flex items-center justify-center transition">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg opacity-80">
                                <span class="text-[#FF2D20] ml-1">▶</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 text-center">
                        <h3 class="font-bold text-sm text-gray-800 truncate">サンプル曲 {{ $i }}</h3>
                        <p class="text-xs text-gray-500 mt-1">2026.01.27</p>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    {{-- ✅ 下2カラム：好きなジャンル / 集計（ダミー） --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10">

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                好きなジャンル
            </h3>
            <div class="flex flex-wrap gap-2 content-start">
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">J-POP</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">Rock</span>
                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">Jazz</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                好きな曲の集計
            </h3>

            <div class="space-y-5">
                @php
                    $stats = [
                        ['title' => 'Pretender', 'count' => 124, 'w' => 90],
                        ['title' => '怪獣の花唄', 'count' => 98, 'w' => 70],
                        ['title' => 'アイドル', 'count' => 85, 'w' => 60],
                    ];
                @endphp

                @foreach($stats as $idx => $s)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gray-700">{{ $idx+1 }}. {{ $s['title'] }}</span>
                            <span class="text-xs text-gray-500">{{ $s['count'] }}回</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-[#FF2D20] h-2 rounded-full" style="width: {{ $s['w'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ✅ アイコン更新（あなたの既存機能） --}}
    <section class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
            プロフィールアイコンを変更
        </h3>

        <form action="{{ route('profile.icon') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="icon" accept="image/*" required
                   class="block w-full text-sm border rounded-lg p-2">
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-full font-bold shadow hover:opacity-90 transition">
                アイコンを更新する
            </button>
        </form>
    </section>

    <div class="text-center mt-8">
        <a href="{{ route('home') }}" class="text-sm font-bold text-blue-600 hover:underline">
            ← トップへ戻る
        </a>
    </div>

</div>
@endsection
