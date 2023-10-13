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
        Schema::table('abonnement_types', function (Blueprint $table) {
            $table->integer('amount_prepa')->nullable();
            $table->integer('amount_bord')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abonnement_types', function (Blueprint $table) {
            $table->dropColumn('amount_prepa');
            $table->dropColumn('amount_bord');
        });
    }
};
