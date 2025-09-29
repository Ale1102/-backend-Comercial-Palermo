<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .invoice-details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>COMERCIAL PALERMO</h1>
        <p>Factura Digital</p>
    </div>

    <div class="content">
        <h2>Estimado(a) {{ $cliente }},</h2>
        
        <p>Adjunto encontrará la factura correspondiente a su compra realizada en nuestro establecimiento.</p>

        <div class="invoice-details">
            <h3>Detalles de la Factura</h3>
            <p><strong>Número de Factura:</strong> {{ $numeroFactura }}</p>
            <p><strong>Fecha:</strong> {{ $venta->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cliente:</strong> {{ $cliente }}</p>
            <p class="total"><strong>Total: ${{ number_format($total, 2) }}</strong></p>
        </div>

        <p>La factura en formato PDF se encuentra adjunta a este correo.</p>

        <p><strong>Resumen de su compra:</strong></p>
        <ul>
            @foreach($venta->detalles as $detalle)
            <li>
                {{ $detalle->producto->nombre }} - 
                Cantidad: {{ $detalle->cantidad }} - 
                ${{ number_format($detalle->subtotal, 2) }}
            </li>
            @endforeach
        </ul>

        <p>Gracias por confiar en nosotros. Si tiene alguna pregunta sobre su factura, no dude en contactarnos.</p>
    </div>

    <div class="footer">
        <p><strong>Comercial Palermo</strong></p>
        <p>Tu socio comercial de confianza</p>
        <p>Este es un correo automático, por favor no responder.</p>
    </div>
</body>
</html>