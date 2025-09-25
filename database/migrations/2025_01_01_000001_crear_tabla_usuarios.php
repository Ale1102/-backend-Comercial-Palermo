<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración para crear tabla usuarios
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            // Clave primaria
            $table->id();
            
            // Datos básicos del usuario
            $table->string('nombre')->comment('Nombre completo del usuario');
            $table->string('email')->unique()->comment('Correo electrónico único');
            $table->string('contraseña')->comment('Contraseña hasheada');
            
            // Rol y estado
            $table->enum('rol', ['admin', 'empleado', 'usuario'])
                  ->default('usuario')
                  ->comment('Rol del usuario en el sistema');
            $table->boolean('activo')->default(true)->comment('Usuario activo o inactivo');
            
            // Verificación de email
            $table->timestamp('email_verificado_en')->nullable();
            
            // Timestamps automáticos
            $table->timestamps();
            
            // Índices para optimización
            $table->index(['email', 'activo']);
            $table->index('rol');
        });
    }

    /**
     * Revertir la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
