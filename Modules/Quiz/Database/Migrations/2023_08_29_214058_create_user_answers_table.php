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
        Schema::table('user_answers', function (Blueprint $table) {
//            $table->id();
//            $table->boolean('ok')->default(false);
//            $table->integer('question_id');
//            $table->integer('user_id');
//            $table->timestamps();
        });

        Schema::table('user_answers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answers');
    }
};
