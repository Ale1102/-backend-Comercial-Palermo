<?php
namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Escritorio Ejecutivo',
                'descripcion' => 'Escritorio de madera con cajones, ideal para oficina',
                'precio' => 450.00,
                'categoria' => 'Muebles de Oficina',
                'stock' => 15,
                'stock_minimo' => 3,
                'codigo_sku' => 'ESC-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Silla Ergonómica',
                'descripcion' => 'Silla de oficina con soporte lumbar ajustable',
                'precio' => 180.00,
                'categoria' => 'Muebles de Oficina',
                'stock' => 25,
                'stock_minimo' => 5,
                'codigo_sku' => 'SIL-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Laptop HP Pavilion',
                'descripcion' => 'Laptop HP Pavilion 15", Intel i5, 8GB RAM, 256GB SSD',
                'precio' => 799.99,
                'categoria' => 'Tecnología',
                'stock' => 8,
                'stock_minimo' => 2,
                'codigo_sku' => 'LAP-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Impresora Multifuncional',
                'descripcion' => 'Impresora HP multifuncional con WiFi',
                'precio' => 120.00,
                'categoria' => 'Tecnología',
                'stock' => 12,
                'stock_minimo' => 3,
                'codigo_sku' => 'IMP-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Mesa de Centro',
                'descripcion' => 'Mesa de centro moderna para sala de espera',
                'precio' => 85.00,
                'categoria' => 'Muebles de Hogar',
                'stock' => 2, // Stock bajo para pruebas
                'stock_minimo' => 5,
                'codigo_sku' => 'MES-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Resma de Papel A4',
                'descripcion' => 'Resma de 500 hojas papel bond A4',
                'precio' => 4.50,
                'categoria' => 'Papelería',
                'stock' => 100,
                'stock_minimo' => 20,
                'codigo_sku' => 'PAP-001',
                'activo' => true,
            ],
            [
                'nombre' => 'Bolígrafos Bic (Pack 12)',
                'descripcion' => 'Pack de 12 bolígrafos azules',
                'precio' => 6.00,
                'categoria' => 'Papelería',
                'stock' => 50,
                'stock_minimo' => 10,
                'codigo_sku' => 'BOL-001',
                'activo' => true,
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}