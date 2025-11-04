<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Middleware\VerificarRol;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;

Route::apiResource('usuarios', UsuarioController::class);



/**
 * Rutas públicas (sin autenticación)
 */
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
         ->name('auth.login');
});

/**
 * Rutas protegidas (requieren autenticación)
 */
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de autenticación
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])
             ->name('auth.logout');
        Route::get('me', [AuthController::class, 'me'])
             ->name('auth.me');
        Route::post('refresh', [AuthController::class, 'refresh'])
             ->name('auth.refresh');
    });
    
    // Aquí se añadirán las rutas de los siguientes sprints:
    // - Productos (Sprint 2)
    // - Ventas (Sprint 3)  
    // - Reportes (Sprint 4)
});

/**
 * Ruta de prueba para verificar la API
 */
Route::get('health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API Comercial Palermo funcionando correctamente',
        'version' => '1.0.0',
        'timestamp' => now()->toISOString()
    ]);
})->name('api.health');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de productos (acceso público autenticado - lectura)
    Route::get('productos', [ProductoController::class, 'index'])
         ->name('productos.index');
    Route::get('productos/{id}', [ProductoController::class, 'show'])
         ->name('productos.show');
    
    // Rutas de productos (admin y empleados - escritura)
    Route::middleware([VerificarRol::class . ':admin,empleado'])->group(function () {
        Route::post('productos', [ProductoController::class, 'store'])
             ->name('productos.store');
        Route::put('productos/{id}', [ProductoController::class, 'update'])
             ->name('productos.update');
        Route::patch('productos/{id}/stock', [ProductoController::class, 'actualizarStock'])
             ->name('productos.stock');
        Route::patch('/productos/{id}/restore', [ProductoController::class, 'restore']);
    });
    
    // Rutas de productos (solo admin - eliminación)
    Route::middleware([VerificarRol::class . ':admin'])->group(function () {
        Route::delete('productos/{id}', [ProductoController::class, 'destroy'])
             ->name('productos.destroy');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // Productos (lectura para todos)
    Route::get('productos', [ProductoController::class, 'index']);
    Route::get('productos/{id}', [ProductoController::class, 'show']);
    
    // Productos (escritura para admin/empleado)
    Route::post('productos', [ProductoController::class, 'store']);
});


Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de ventas (admin y empleados)
    Route::middleware([VerificarRol::class . ':admin,empleado'])->group(function () {
        Route::post('ventas', [VentaController::class, 'store'])
             ->name('ventas.store');
        Route::get('ventas', [VentaController::class, 'index'])
             ->name('ventas.index');
        Route::get('ventas/{id}', [VentaController::class, 'show'])
             ->name('ventas.show');
        Route::get('ventas/{id}/pdf', [VentaController::class, 'generarPDF'])
             ->name('ventas.pdf');
        Route::post('ventas/{id}/email', [VentaController::class, 'enviarEmail'])
             ->name('ventas.email');
    });
    
    // Rutas de ventas (solo admin)
    Route::middleware([VerificarRol::class . ':admin'])->group(function () {
        Route::patch('ventas/{id}/cancelar', [VentaController::class, 'cancelar'])
             ->name('ventas.cancelar');
    });
});

Route::post('ventas/{id}/email', [VentaController::class, 'enviarEmail'])
     ->middleware(['auth:sanctum', 'verificar.rol:admin,empleado']);


Route::middleware('auth:sanctum')->group(function () {
    
    // Dashboard (todos los usuarios autenticados)
    Route::get('dashboard', [ReporteController::class, 'dashboard'])
         ->name('dashboard');
    
    // Reportes (admin y empleados)
    Route::middleware([VerificarRol::class . ':admin,empleado'])->prefix('reportes')->group(function () {
        Route::get('ventas', [ReporteController::class, 'reporteVentas'])
             ->name('reportes.ventas');
        Route::get('productos-populares', [ReporteController::class, 'productosPopulares'])
             ->name('reportes.productos-populares');
        Route::get('stock-bajo', [ReporteController::class, 'stockBajo'])
             ->name('reportes.stock-bajo');
        Route::get('financiero', [ReporteController::class, 'reporteFinanciero'])
             ->name('reportes.financiero');
    });
    
    // Reportes avanzados (solo admin)
    Route::middleware([VerificarRol::class . ':admin'])->prefix('reportes')->group(function () {
        Route::get('vendedores', [ReporteController::class, 'reporteVendedores'])
             ->name('reportes.vendedores');
    });
});

// Rutas públicas (SIN autenticación)
Route::get('productos', [ProductoController::class, 'index']);
Route::get('productos/{id}', [ProductoController::class, 'show']);
