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
        // Ensure the 'time' column is added only if it doesn't already exist
        Schema::table('gas_sensors', function (Blueprint $table) {
            if (!Schema::hasColumn('gas_sensors', 'time')) {
                $table->time('time')->nullable(); // Add 'time' column if it doesn't exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('gas_sensors', function (Blueprint $table) {
            // Check if the column exists before dropping it
            if (Schema::hasColumn('gas_sensors', 'time')) {
                $table->dropColumn('time');
            }
        });
    }
};
