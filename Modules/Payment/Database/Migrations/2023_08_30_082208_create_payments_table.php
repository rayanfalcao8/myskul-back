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
        Schema::table('payments', function (Blueprint $table) {
//            $table->id();
//            $table->string('transactionID');
//            $table->string('transactionType');
//            $table->string('phoneNumber');
//            $table->integer('montant');
//            $table->string('service_sigle');
//            $table->integer('user_id');
//            $table->string('createdAt');
//            $table->string('status');
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
        Schema::dropIfExists('payments');
    }
};
