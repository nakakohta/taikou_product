<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            // すでに song_id があるなら何もしない（安全対策）
            if (Schema::hasColumn('comments', 'song_id')) {
                return;
            }

            // ✅ 追加するのは song_id だけ（user_id は既にあるので追加しない）
            $table->foreignId('song_id')
                ->nullable()
                ->after('user_id')
                ->constrained('songs')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'song_id')) {
                $table->dropForeign(['song_id']);
                $table->dropColumn('song_id');
            }
        });
    }
};
