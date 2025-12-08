<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MusicController;

// -------------------------------------------
// トップページ
// -------------------------------------------
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// -------------------------------------------
// 🎨 テーマ設定ページ（表示）
// -------------------------------------------
Route::get('/theme', function () {
    return view('theme');
})->name('theme');

// -------------------------------------------
// 🎨 テーマ切り替え処理（POST）
// -------------------------------------------
Route::post('/theme/change', function (\Illuminate\Http\Request $request) {
    $theme = $request->input('theme', 'light');
    session(['theme' => $theme]);
    return back();
})->name('theme.change');

// -------------------------------------------
// 曲投稿ページ（仮表示） ←★ これを追加！
// -------------------------------------------
Route::get('/songs/create', function () {
    return 'ここに曲投稿ページを作る（仮ページ）';
})->name('songs.create');

// -------------------------------------------
// ログイン（ダミー）
// -------------------------------------------
Route::get('/login', function () {
    return 'ここにログインページを作る';
})->name('login');

// -------------------------------------------
// 新規登録
// -------------------------------------------
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');

Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');


// -------------------------------------------
// 曲ページ表示
// -------------------------------------------



Route::get('/profile', function () {
    return view('profile');
});
// 🎵 曲ページ表示

Route::get('/music/{id}', [MusicController::class, 'show'])
    ->name('music.show');

// -------------------------------------------
// コメント投稿（ログイン必須）
// -------------------------------------------
Route::post('/music/{id}/comment', [MusicController::class, 'storeComment'])
    ->middleware('auth')
    ->name('comment.store');
