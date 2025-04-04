<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('gas_sensors', function (Blueprint $table) {
            $table->id();
            $table->float('value');  // Niveau du gaz
            $table->timestamp('time')->useCurrent();  // Date de la mesure
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas_sensors');
    }
};
