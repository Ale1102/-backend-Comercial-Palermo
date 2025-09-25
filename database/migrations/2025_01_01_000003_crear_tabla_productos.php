<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            
            // Información básica del producto
            $table->string('nombre')->comment('Nombre del producto');
            $table->text('descripcion')->nullable()->comment('Descripción detallada');
            $table->decimal('precio', 10, 2)->comment('Precio unitario del producto');
            
            // Categoría y clasificación
            $table->string('categoria', 100)->comment('Categoría del producto');
            $table->string('codigo_sku', 100)->unique()->nullable()->comment('Código único');
            
            // Control de inventario
            $table->integer('stock')->default(0)->comment('Cantidad en inventario');
            $table->integer('stock_minimo')->default(5)->comment('Cantidad mínima para alerta');
            
            // Multimedia y estado
            $table->string('url_imagen', 500)->nullable()->comment('URL de la imagen');
            $table->boolean('activo')->default(true)->comment('Producto activo o inactivo');
            
            $table->timestamps();
            
            // Índices para búsquedas optimizadas
            $table->index(['categoria', 'activo']);
            $table->index(['stock', 'stock_minimo']);
            $table->index('nombre');
            $table->fullText('nombre'); // Búsqueda de texto completo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};