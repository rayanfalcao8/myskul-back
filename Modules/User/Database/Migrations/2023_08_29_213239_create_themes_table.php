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
        Schema::table('themes', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->boolean('free')->default(false);
//            $table->unsignedBigInteger('category_id');
//            $table->unsignedBigInteger('level_id');
//            $table->unsignedBigInteger('speciality_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
};
