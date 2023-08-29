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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('timezone')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('language')->default('Français');
            $table->boolean('status')->default(true);
            $table->string('otp_code')->nullable();
            $table->timestamp('phone_number_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('timezone');
            $table->dropColumn('last_login_ip');
            $table->dropColumn('last_login_at')->nullable();
            $table->dropColumn('language');
            $table->dropColumn('status');
            $table->dropColumn('otp_code');
            $table->dropColumn('phone_number_verified_at');
        });
    }
};
