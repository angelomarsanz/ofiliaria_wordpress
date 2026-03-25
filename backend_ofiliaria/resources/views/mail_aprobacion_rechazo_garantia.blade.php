<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #f2f2f2;
            padding: 20px;
        }
        h1 {
            color: #444;
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($datos->aprobacion_garantia == 'Sí')
            <p>Estimado usuario: Su garantía fue aprobada</p>
        @else
            <p>Estimado usuario: Su garantía fue rechazada por el siguiente motivo:</p>
            <p>{{ $datos->notas_garantia }}</p>
        @endif
    </div>
</body>
</html>
