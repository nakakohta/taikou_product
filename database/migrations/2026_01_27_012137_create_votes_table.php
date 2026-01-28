<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->constrained('songs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('rating'); // 1〜5
            $table->timestamps();

            $table->unique(['song_id', 'user_id']); // ✅ 1曲に1回だけ評価
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
