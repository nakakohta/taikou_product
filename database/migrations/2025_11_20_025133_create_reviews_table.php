<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // 追加する必要がある項目
            $table->unsignedBigInteger('music_id');  // 対象の曲
            $table->text('review')->nullable();      // レビュー本文
            $table->integer('rating')->default(0);   // 星の数（0〜5など）

            $table->timestamps();

            // 外部キー設定（music テーブルと連動）
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
        Schema::dropIfExists('reviews');
    }
}
