<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_venta', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales
            $table->foreignId('id_venta')
                  ->constrained('ventas')
                  ->onDelete('cascade')
                  ->comment('ID de la venta asociada');
                  
            $table->foreignId('id_producto')
                  ->constrained('productos')
                  ->onDelete('restrict')
                  ->comment('ID del producto vendido');
            
            // Detalles de la venta
            $table->integer('cantidad')->comment('Cantidad vendida del producto');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio al momento de la venta');
            $table->decimal('subtotal', 10, 2)->comment('Total por este producto');
            
            $table->timestamp('creado_en')->useCurrent();
            
            // Índices
            $table->index(['id_venta', 'id_producto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_venta');
    }
};