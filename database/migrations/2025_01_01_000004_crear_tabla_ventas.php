<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            
            // Información del cliente
            $table->string('nombre_cliente')->comment('Nombre del cliente');
            $table->string('email_cliente')->nullable()->comment('Email del cliente');
            $table->string('telefono_cliente', 20)->nullable()->comment('Teléfono del cliente');
            
            // Información de la venta
            $table->decimal('total', 10, 2)->comment('Total de la venta');
            $table->enum('estado', ['pendiente', 'completada', 'cancelada'])
                  ->default('completada')
                  ->comment('Estado de la venta');
            $table->string('numero_factura', 50)->unique()->nullable()
                  ->comment('Número único de factura');
            
            // Relación con usuario que realizó la venta
            $table->foreignId('id_usuario')
                  ->nullable()
                  ->constrained('usuarios')
                  ->onDelete('set null')
                  ->comment('Usuario que realizó la venta');
            
            $table->timestamps();
            
            // Índices CORREGIDOS - ÍNDICES SEPARADOS
            $table->index(['created_at', 'estado']);
            $table->index('nombre_cliente'); // Índice individual
            $table->index('email_cliente');  // Índice individual
            $table->index('numero_factura');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};