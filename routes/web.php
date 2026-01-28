<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\MusicController;

// トップ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 認証
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', fn () => view('register'))->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// 曲ページ（閲覧）
Route::get('/music/{id}', [MusicController::class, 'show'])->name('music.show');

// ✅ ログイン必須
Route::middleware('auth')->group(function () {

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/icon', [ProfileController::class, 'updateIcon'])->name('profile.icon');

    // 曲投稿
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store');

    // コメント投稿
    Route::post('/music/{id}/comment', [MusicController::class, 'storeComment'])->name('comment.store');

    // ★評価（votes） ← これが無いせいで vote.store が未定義になっていました
    Route::post('/music/{id}/vote', [MusicController::class, 'storeVote'])->name('vote.store');
});
