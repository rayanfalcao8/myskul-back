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
        Schema::table('messages', function (Blueprint $table) {
//            $table->id();
//            $table->text('message');
//            $table->string('sendAt');
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('speciality_id');
//            $table->unsignedBigInteger('level_id');
//
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
