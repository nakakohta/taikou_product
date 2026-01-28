<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'music_id') && !Schema::hasColumn('comments', 'song_id')) {
                $table->renameColumn('music_id', 'song_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'song_id') && !Schema::hasColumn('comments', 'music_id')) {
                $table->renameColumn('song_id', 'music_id');
            }
        });
    }
};
