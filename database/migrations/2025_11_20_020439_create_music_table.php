<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('music', function (Blueprint $table) {
            $table->id();

            // ★ ここから追加部分 ★
            $table->string('title');              // 曲名
            $table->string('thumbnail');          // サムネ画像ファイル名
            $table->text('description');          // 概要（説明欄）
            $table->integer('review')->default(0); // 星レビュー（0〜5）  
            // ★ ここまで ★

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music');
    }
}
