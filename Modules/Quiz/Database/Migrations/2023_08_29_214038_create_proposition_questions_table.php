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
        Schema::table('proposition_questions', function (Blueprint $table) {
//            $table->id();
//            $table->boolean('isCorrect')->default(false);

            $table->unsignedBigInteger('proposition_id')->change();
            $table->unsignedBigInteger('question_id')->change();
            $table->timestamps();

            $table->foreign('proposition_id')->references('id')->on('propositions');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposition_questions');
    }
};
