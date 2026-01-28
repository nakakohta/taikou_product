<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // ✅ 追加したいジャンル一覧（表示順も一緒に管理）
        $genres = [
            ['name' => 'EDM',      'sort_order' => 10],
            ['name' => 'HIPHOP',   'sort_order' => 20],
            ['name' => 'J-POP',    'sort_order' => 30],
            ['name' => 'K-POP',    'sort_order' => 40],
            ['name' => 'Lo-Fi',    'sort_order' => 50],
            ['name' => 'R&B',      'sort_order' => 60],
            ['name' => 'アニソン',   'sort_order' => 70],
            ['name' => 'インスト',   'sort_order' => 80],
            ['name' => 'クラシック', 'sort_order' => 90],
            ['name' => 'ゲーム音楽', 'sort_order' => 100],
            ['name' => 'シティポップ', 'sort_order' => 110],
            ['name' => 'ジャズ',     'sort_order' => 120],
            ['name' => 'その他',     'sort_order' => 130],
            ['name' => 'チル',       'sort_order' => 140],
            ['name' => 'テクノ',     'sort_order' => 150],
            ['name' => 'バラード',   'sort_order' => 160],
            ['name' => 'ボカロ',     'sort_order' => 170],
        ];

        foreach ($genres as $g) {
            // ✅ すでに同名があれば追加しない（重複防止）
            $exists = DB::table('genres')->where('name', $g['name'])->exists();
            if ($exists) continue;

            DB::table('genres')->insert([
                'name' => $g['name'],
                'sort_order' => $g['sort_order'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // ✅ このマイグレーションで入れたジャンルだけ消す
        DB::table('genres')->whereIn('name', [
            'EDM','HIPHOP','J-POP','K-POP','Lo-Fi','R&B','アニソン','インスト','クラシック',
            'ゲーム音楽','シティポップ','ジャズ','その他','チル','テクノ','バラード','ボカロ'
        ])->delete();
    }
};
