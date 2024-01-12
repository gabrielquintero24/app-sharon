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
        Schema::create('corte', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_referencia')->unique();
            $table->integer('cantidad_salida')->nullable()->comment("total de prendas cortadas");
            $table->integer('cantidad_entrada')->nullable()->comment("total de prendas entregadas");
            $table->date('fecha_creacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corte');
    }
};
