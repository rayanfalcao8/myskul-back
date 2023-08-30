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
        Schema::table('user_abonnements', function (Blueprint $table) {
//            $table->id();
//            $table->integer('user_id');
//            $table->integer('abonnementType_id');
//            $table->string('transactionID');
//            $table->string('buyerPhoneNumber');
//            $table->integer('level_id');
//            $table->integer('speciality_id');
//            $table->string('createdAt');
//            $table->string('expiresAt');

            $table->foreign('abonnementType_id')->references('id')->on('abonnement_types');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_abonnements');
    }
};
