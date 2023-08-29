<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_themes', function (Blueprint $table) {
//            $table->id();
//            $table->boolean('done')->default(false);
//            $table->integer('score');
//            $table->integer('theme_id');
//            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::table('user_themes', function (Blueprint $table) {
            $table->foreign('theme_id')->references('id')->on('themes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_themes');
    }
};
