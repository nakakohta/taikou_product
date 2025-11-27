<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('songs', function (Blueprint $table) {
        $table->id(); // BIGINT PK
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
        $table->string('url', 500);
        $table->string('title', 255);
        $table->string('artist', 255);
        $table->text('comment')->nullable();
        $table->timestamps(); // created_at / updated_at
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
