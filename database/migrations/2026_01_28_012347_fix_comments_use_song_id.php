<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('comments')) return;

        // 1) song_id を追加（なければ）
        if (!Schema::hasColumn('comments', 'song_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->unsignedBigInteger('song_id')->nullable()->after('user_id');
            });
        }

        // 2) music_id があるなら song_id にコピー
        if (Schema::hasColumn('comments', 'music_id')) {
            DB::statement("UPDATE comments SET song_id = music_id WHERE song_id IS NULL");
        }

        // 3) song_id を NOT NULL に（安全のため、空がある場合は残す）
        // ここはプロジェクト状況により nullable のままでもOK

        // 4) 外部キー（すでにあれば無視）
        try {
            Schema::table('comments', function (Blueprint $table) {
                $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
            });
        } catch (\Throwable $e) {
            // ignore
        }

        // 5) もう不要なので music_id を削除（存在する場合）
        if (Schema::hasColumn('comments', 'music_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('music_id');
            });
        }
    }

    public function down(): void
    {
        // ロールバック不要（安全のため空）
    }
};
