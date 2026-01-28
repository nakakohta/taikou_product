<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            // 🔴 ① music_id があれば削除
            if (Schema::hasColumn('comments', 'music_id')) {
                try {
                    $table->dropForeign(['music_id']);
                } catch (\Throwable $e) {
                    // 外部キーが無い場合もあるので無視
                }
                $table->dropColumn('music_id');
            }

            // 🟢 ② song_id を追加（無ければ）
            if (!Schema::hasColumn('comments', 'song_id')) {
                $table->foreignId('song_id')
                      ->after('id')
                      ->constrained('songs')
                      ->onDelete('cascade');
            }

            // 🟢 ③ user_id（すでにあれば何もしない）
            if (!Schema::hasColumn('comments', 'user_id')) {
                $table->foreignId('user_id')
                      ->after('song_id')
                      ->constrained('users')
                      ->onDelete('cascade');
            }

            // 🟢 ④ comment（すでにあれば何もしない）
            if (!Schema::hasColumn('comments', 'comment')) {
                $table->text('comment')->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            if (Schema::hasColumn('comments', 'song_id')) {
                try {
                    $table->dropForeign(['song_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('song_id');
            }

            // 元に戻す用（今回はほぼ使わない）
            if (!Schema::hasColumn('comments', 'music_id')) {
                $table->unsignedBigInteger('music_id')->nullable();
            }
        });
    }
};
