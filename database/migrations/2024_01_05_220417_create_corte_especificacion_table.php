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
        Schema::create('corte_especificacion', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->integer('precio');
            $table->foreignId('corte_id')->constrained(table: 'corte');
            $table->foreignId('especificacion_id')->constrained(table: 'especificacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corte_especificacion');
    }
};
