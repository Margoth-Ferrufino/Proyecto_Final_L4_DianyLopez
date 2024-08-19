<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>@yield('titulo')</title>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Enlaces de navegación a la izquierda -->
            <div class="navbar-header">
                <a class="navbar-brand text-primary" href="#">Red Social</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('publicaciones.index') }}">Publicaciones</a>
                    </li>
                    <!-- Otros enlaces de navegación aquí si los tienes -->
                </ul>
            </div>
            <!-- Nombre de usuario en la parte superior derecha fuera del collapse -->
            <span class="navbar-text text-primary ml-auto">
            {{ auth()->user()->name }}
        </span>
        </div>
    </nav>

</head>
<body>
<div class="container">
    @yield('contenido')
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
