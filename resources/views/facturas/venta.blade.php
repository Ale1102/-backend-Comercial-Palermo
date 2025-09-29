?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $venta->numero_factura }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .invoice-info .left, .invoice-info .right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .invoice-info .right {
            text-align: right;
        }
        .client-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .products-table th {
            background-color: #007bff;
            color: white;
        }
        .products-table .text-right {
            text-align: right;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">COMERCIAL PALERMO</div>
        <p>Tu socio comercial de confianza</p>
    </div>

    <div class="invoice-info">
        <div class="left">
            <h3>Información de Factura</h3>
            <p><strong>Número:</strong> {{ $venta->numero_factura }}</p>
            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Vendedor:</strong> {{ $venta->usuario->nombre ?? 'Sistema' }}</p>
        </div>
        <div class="right">
            <h3>Estado de Venta</h3>
            <p><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</p>
            <p><strong>Método:</strong> Mostrador</p>
        </div>
    </div>

    <div class="client-info">
        <h3>Información del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $venta->nombre_cliente }}</p>
        @if($venta->email_cliente)
            <p><strong>Email:</strong> {{ $venta->email_cliente }}</p>
        @endif
        @if($venta->telefono_cliente)
            <p><strong>Teléfono:</strong> {{ $venta->telefono_cliente }}</p>
        @endif
    </div>

    <h3>Productos Vendidos</h3>
    <table class="products-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th class="text-right">Precio Unit.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td>
                    <strong>{{ $detalle->producto->nombre }}</strong>
                    @if($detalle->producto->descripcion)
                        <br><small>{{ $detalle->producto->descripcion }}</small>
                    @endif
                </td>
                <td>{{ number_format($detalle->cantidad) }}</td>
                <td class="text-right">${{ number_format($detalle->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($detalle->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Subtotal:</strong> ${{ number_format($venta->total, 2) }}</p>
        <p><strong>IVA (0%):</strong> $0.00</p>
        <p class="total-amount"><strong>TOTAL: ${{ number_format($venta->total, 2) }}</strong></p>
    </div>

    <div class="footer">
        <p>Gracias por su compra - Comercial Palermo</p>
        <p>Factura generada el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>

<?php