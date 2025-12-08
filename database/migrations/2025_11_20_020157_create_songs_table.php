<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id(); // 曲ID（BIGINT PK）
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 投稿者ユーザーID（FK）
            $table->foreignId('genre_id')->constrained()->onDelete('cascade'); // ジャンルID（FK）
            $table->string('url', 500); // 動画 / 音楽のURL
            $table->string('title', 255); // 曲名
            $table->string('artist', 255); // アーティスト名
            $table->text('comment'); // 投稿者コメント（好きな理由）
            $table->timestamps(); // created_at, updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
