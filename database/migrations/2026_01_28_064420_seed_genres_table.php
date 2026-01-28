<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 追加したいジャンル一覧
        $names = [
            'EDM','HIPHOP','J-POP','K-POP','Lo-Fi','R&B',
            'アニソン','インスト','クラシック','ゲーム音楽',
            'シティポップ','ジャズ','その他','チル','テクノ','バラード','ボカロ'
        ];

        foreach ($names as $name) {
            DB::table('genres')->updateOrInsert(
                ['name' => $name], // すでにあれば更新、なければ追加
                [
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        DB::table('genres')->whereIn('name', [
            'EDM','HIPHOP','J-POP','K-POP','Lo-Fi','R&B',
            'アニソン','インスト','クラシック','ゲーム音楽',
            'シティポップ','ジャズ','その他','チル','テクノ','バラード','ボカロ'
        ])->delete();
    }
};
