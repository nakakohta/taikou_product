<?php
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

// 新規登録画面
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');

// 新規登録処理
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');



Route::get('/profile', function () {
    return view('profile');
});
// 🎵 曲ページ表示
Route::get('/music/{id}', [MusicController::class, 'show'])
    ->name('music.show');

// 📝 コメント投稿処理（ログイン必須）
Route::post('/music/{id}/comment', [MusicController::class, 'storeComment'])
    ->middleware('auth')
    ->name('comment.store');

