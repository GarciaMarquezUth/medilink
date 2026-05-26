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
            Schema::create('citas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('paciente_id')->constrained()->onDelete('cascade');
        $table->foreignId('medico_id')->constrained()->onDelete('cascade');
        $table->foreignId('servicio_id')->constrained()->onDelete('cascade');
        $table->dateTime('fecha_inicio'); // Fecha y hora exactas de inicio
        $table->dateTime('fecha_fin');    // Calculada en backend al guardar
        $table->enum('estado', ['agendada', 'confirmada', 'atendida', 'cancelada', 'no-show'])->default('agendada');
        $table->text('notas')->nullable();
        $table->timestamps();

        // Índice para que la validación de traslapes en tiempo real vuele
        $table->index(['medico_id', 'fecha_inicio', 'fecha_fin', 'estado']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
