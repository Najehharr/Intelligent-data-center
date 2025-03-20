<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('gas_sensors', function (Blueprint $table) {
            $table->float('value')->after('id'); // Add 'value' column
            $table->time('time')->nullable(); // Add 'time' column
        });
    }

    public function down()
    {
        Schema::table('gas_sensors', function (Blueprint $table) {
            $table->dropColumn('value'); // Drop 'value' column
            $table->dropColumn('time');  // Drop 'time' column
        });
    }
};
