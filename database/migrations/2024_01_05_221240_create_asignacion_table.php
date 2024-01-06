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
        Schema::create('asignacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modista_id')->constrained(table: 'modista');
            $table->foreignId('corte_id')->constrained(table: 'corte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion');
    }
};
