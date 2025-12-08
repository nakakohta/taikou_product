<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailToSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            // すでに存在しない場合だけ追加（安全）
            if (!Schema::hasColumn('songs', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('comment');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            if (Schema::hasColumn('songs', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }
}
