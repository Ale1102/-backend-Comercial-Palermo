<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique()->comment('Nombre de la categoría');
            $table->text('descripcion')->nullable()->comment('Descripción de la categoría');
            $table->boolean('activa')->default(true)->comment('Categoría activa o inactiva');
            $table->timestamps();
            
            // Índices
            $table->index(['nombre', 'activa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};