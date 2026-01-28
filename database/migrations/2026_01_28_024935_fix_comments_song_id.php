<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) song_id が無ければ追加
        if (!Schema::hasColumn('comments', 'song_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->unsignedBigInteger('song_id')->nullable()->after('id');
            });
        }

        // 2) もし music_id が残っているなら song_id に移す
        if (Schema::hasColumn('comments', 'music_id')) {
            DB::statement("UPDATE comments SET song_id = music_id WHERE song_id IS NULL");

            Schema::table('comments', function (Blueprint $table) {
                $table->dropColumn('music_id');
            });
        }

        // 3) user_id / comment が無いケースも保険（基本は既にあるはず）
        if (!Schema::hasColumn('comments', 'user_id')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('song_id');
            });
        }

        if (!Schema::hasColumn('comments', 'comment')) {
            Schema::table('comments', function (Blueprint $table) {
                $table->text('comment')->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        // 戻す必要がなければ空でOK
    }
};
