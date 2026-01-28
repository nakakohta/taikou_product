<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = false;

        try {
            $indexes = DB::select(
                "SHOW INDEX FROM `votes` WHERE Key_name = 'votes_song_id_user_id_unique'"
            );
            $exists = !empty($indexes);
        } catch (\Throwable $e) {}

        if (!$exists) {
            Schema::table('votes', function (Blueprint $table) {
                $table->unique(['song_id', 'user_id'], 'votes_song_id_user_id_unique');
            });
        }
    }

    public function down(): void
    {
        $exists = false;

        try {
            $indexes = DB::select(
                "SHOW INDEX FROM `votes` WHERE Key_name = 'votes_song_id_user_id_unique'"
            );
            $exists = !empty($indexes);
        } catch (\Throwable $e) {}

        if ($exists) {
            Schema::table('votes', function (Blueprint $table) {
                $table->dropUnique('votes_song_id_user_id_unique');
            });
        }
    }
};
