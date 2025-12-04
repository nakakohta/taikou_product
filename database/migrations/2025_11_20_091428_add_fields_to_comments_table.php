<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCommentsTable extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {

            // user_id（コメントしたユーザー）
            if (!Schema::hasColumn('comments', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }

            // music_id（対象の曲）
            if (!Schema::hasColumn('comments', 'music_id')) {
                $table->unsignedBigInteger('music_id')->after('user_id');
            }

            // comment（本文）
            if (!Schema::hasColumn('comments', 'comment')) {
                $table->text('comment')->after('music_id');
            }
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('comments', 'music_id')) {
                $table->dropColumn('music_id');
            }
            if (Schema::hasColumn('comments', 'comment')) {
                $table->dropColumn('comment');
            }
        });
    }
}
