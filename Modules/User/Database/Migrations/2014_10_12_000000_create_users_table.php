<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->string('email')->change();
            $table->string('gender')->nullable()->change();
            $table->string('birthdate')->nullable()->change();
//            $table->string('password');
            $table->string('phoneNumber')->nullable()->change();
            $table->string('town')->nullable()->change();
            $table->unsignedBigInteger('level_id')->nullable()->change();
            $table->unsignedBigInteger('speciality_id')->nullable()->change();
            $table->string('avatarURL')->nullable()->change();
            $table->string('token')->nullable()->change();
//            $table->timestamp('email_verified_at')->nullable();
//            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
