<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // ✅ 初期投入（必要なら増やしてOK）
        $now = now();
        $rows = [
            ['name' => 'EDM', 'sort_order' => 0],
            ['name' => 'HIPHOP', 'sort_order' => 0],
            ['name' => 'J-POP', 'sort_order' => 0],
            ['name' => 'K-POP', 'sort_order' => 0],
            ['name' => 'Lo-Fi', 'sort_order' => 0],
            ['name' => 'R&B', 'sort_order' => 0],
            ['name' => 'アニソン', 'sort_order' => 0],
            ['name' => 'インスト', 'sort_order' => 0],
            ['name' => 'クラシック', 'sort_order' => 0],
            ['name' => 'ゲーム音楽', 'sort_order' => 0],
            ['name' => 'シティポップ', 'sort_order' => 0],
            ['name' => 'ジャズ', 'sort_order' => 0],
            ['name' => 'その他', 'sort_order' => 0],
            ['name' => 'チル', 'sort_order' => 0],
            ['name' => 'テクノ', 'sort_order' => 0],
            ['name' => 'バラード', 'sort_order' => 0],
            ['name' => 'ボカロ', 'sort_order' => 0],
        ];

        DB::table('genres')->insert(array_map(function ($r) use ($now) {
            return $r + ['created_at' => $now, 'updated_at' => $now];
        }, $rows));
    }

    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
