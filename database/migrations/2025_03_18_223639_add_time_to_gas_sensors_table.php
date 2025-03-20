<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('gas_sensors', function (Blueprint $table) {
            $table->time('time')->nullable(); // Ensure 'time' is added correctly
        });
    }

    public function down()
    {
        Schema::table('gas_sensors', function (Blueprint $table) {
            if (Schema::hasColumn('gas_sensors', 'time')) {
                $table->dropColumn('time');
            }
        });
    }


};
