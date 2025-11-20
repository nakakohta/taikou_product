<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
