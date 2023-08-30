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
        Schema::create('user_domains', function (Blueprint $table) {
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->integer('user_id')->nullable();

            $table->foreign('domain_id')->references('id')->on('domaines');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_domains');
    }
};
