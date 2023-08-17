<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id');
            $table->string('number');
            $table->string('payment_status'); // Attente, payée, non payée
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inoices');
    }
};
