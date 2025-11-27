<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MusicController;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// 新規登録画面
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');

// 新規登録処理
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

// 🎵 曲ページ表示
Route::get('/music/{id}', [MusicController::class, 'show'])
    ->name('music.show');

// 📝 コメント投稿処理（ログイン必須）
Route::post('/music/{id}/comment', [MusicController::class, 'storeComment'])
    ->middleware('auth')
    ->name('comment.store');
