<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->constrained('songs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // ✅ 同じユーザーが同じ曲を二重登録できない
            $table->unique(['song_id', 'user_id'], 'favorites_song_id_user_id_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
