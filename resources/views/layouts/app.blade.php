<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap 5 CSS via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CSS via CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <!-- Cleave masks via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

        <title>Desafio Técnico Spassu</title>
    </head>

    <body class="font-sans antialiased">
        <!-- Menu de Navegação -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">Desafio Spassu - PHP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item ">
                            <a class="nav-link active" href="{{ url('/') }}"> <i class="fas fa-book"></i> Livros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/authors') }}"> <i class="fas fa-user"></i> Autores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/subjects') }}"> <i class="fas fa-pen-nib"></i> Assuntos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="d-flex justify-content-center align-items-center" style="padding: 30px;">
            <div class="card pt-5 pb-5 p-2" style="width: 100%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                @yield('content')
            </div>
        </div>

        <!-- Bootstrap 5 JS via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
