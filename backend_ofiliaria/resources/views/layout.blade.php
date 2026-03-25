<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Pruebas @yield('title')</title>
</head>
<body>
    <div class="container mt-3">
        <h2>Pruebas</h2>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href='{{url("pruebas")}}'>Listado</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href='{{url("pruebas/create")}}'>Crear</a>
            </li>
        </ul>
    </div>
    <div class='container mt-3'>
        @yield('body')
    </div>
</body>
</html>