<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\VerificarRol;

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

