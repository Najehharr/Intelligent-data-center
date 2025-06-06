<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temperature_sensors', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->timestamp('time')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('temperatures');
    }
};
