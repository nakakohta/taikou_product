<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('music')->insert([
            [
                'thumbnail' => 'sample1.jpg',      // サムネ画像
                'title'     => 'サンプル曲 1',
                'description' => 'これはサンプルの曲説明です。',
                'review'    => 4,                 // 1〜5 のレビュー
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'thumbnail' => 'sample2.jpg',
                'title'     => 'サンプル曲 2',
                'description' => '紹介テキストが入ります。',
                'review'    => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
