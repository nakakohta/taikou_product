<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {

            // user_id が存在しない場合のみ追加
            if (!Schema::hasColumn('comments', 'user_id')) {

                $table->unsignedBigInteger('user_id')->after('id');

                // users.id に紐づく外部キー制約
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
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
        Schema::table('comments', function (Blueprint $table) {

            if (Schema::hasColumn('comments', 'user_id')) {

                // 外部キー削除
                $table->dropForeign(['user_id']);

                // カラム削除
                $table->dropColumn('user_id');
            }
        });
    }
}
