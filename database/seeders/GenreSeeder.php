<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $genres = [
            ['name' => 'JPOP', 'sort_order' => 1],
            ['name' => 'KPOP', 'sort_order' => 2],
            ['name' => 'ロック', 'sort_order' => 3],
            ['name' => 'ヒップホップ', 'sort_order' => 4],
            ['name' => 'アニソン', 'sort_order' => 5],
            ['name' => 'ボカロ', 'sort_order' => 6],
        ];

        foreach ($genres as $g) {
            DB::table('genres')->updateOrInsert(
                ['name' => $g['name']],
                ['sort_order' => $g['sort_order'], 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
