<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // 曲への紐付け
            $table->unsignedBigInteger('music_id');

            // コメント投稿者
            $table->string('name')->nullable();      // 投稿者名
            $table->string('icon')->nullable();      // アイコン画像のパス

            // 評価(★)
            $table->integer('rating')->default(0);

            // コメント本文
            $table->text('comment')->nullable();

            $table->timestamps();

            // 外部キー制約（musicテーブルへ）
            $table->foreign('music_id')
                  ->references('id')
                  ->on('music')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
