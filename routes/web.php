<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// 曲投稿ページ
Route::get('/songs/create', function () {
    return 'ここに曲投稿ページを作る';
})->name('songs.create');

// ログインページ（ダミー）
Route::get('/login', function () {
    return 'ここにログインページを作る';
})->name('login');

// 新規登録ページ（ダミー）
Route::get('/register', function () {
    return 'ここに新規登録ページを作る';
})->name('register');  
// Auth::routes();  ← 今はコメントアウト or 削除でOK
