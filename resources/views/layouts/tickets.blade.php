<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .file-note{
            color: gray;
            font-style:italic;
            font-family: cursive;
            font-size: 14px;
        }

        .form-container {
            max-width: 900px;
            /* margin: 50px auto; */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }
        .form-group label {
            font-weight: bold;
        }
        .form-group select,
        .form-group input,
        .form-group textarea {
            border-radius: 5px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            width: 100%;
            padding: 10px;
            font-size: 15px;
        }

        .btn-custom-end-dataTable {
            margin-top: 20px;
            margin-right: 10px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            margin-left: 2px;
            border-radius: 3px;
        }
        /* LOADER */
        .loading {
            z-index: 20;
            position: absolute;
            top: 0;
            /* left:-5px; */
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.168);
        }

        /*CIRCULO*/
        .loading-content {
            position: absolute;
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #0099ff; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            top: 50%;
            left:50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* INPUTS file */


    </style>

    @yield('css')
</head>

<body>
    <section id="loading">
        <div id="loading-content"></div>
    </section>

    {{-- BARRA DE NAVEGACIÓN --}}
    @auth
        <ul class="nav nav-tabs justify-content-center">

            <li class="nav-item">
                <a class="nav-link {{ Route::is('consultar.ticket') ? 'active' : '' }}" href="{{ route('consultar.ticket') }}"> <i class="fa-solid fa-house"></i> Panel </a>
            </li>

            @if (Auth::user()->rol == 'director')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('consultar.ticket.pasado') ? 'active' : '' }}" href="{{ route('consultar.ticket.pasado') }}"> <i class="fa-solid fa-arrow-up-from-bracket"></i> Evidencias </a>
                </li>
            @endif

            @if (Auth::user()->rol == 'coordinador')
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('reporte.ticket') ? 'active' : '' }}" href="{{ route('reporte.ticket') }}"> <i class="fa-regular fa-file-excel"></i> Reportes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::is('modificar.personal') ? 'active' : '' }}" href="{{ route('modificar.personal') }}"> <i class="fa-solid fa-users"></i></i> Personal</a>
                </li>
            @endif

            @if (Auth::user()->rol == 'coordinador' && Auth::user()->userable->VALIDACION)
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('consultar.ticket.pago') ? 'active' : '' }}" href="{{ route('consultar.ticket.pago') }}"> <i class="fa-regular fa-money-bill-1"></i> Pagos</a>
                </li>
            @endif


            {{-- USUARIO --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    {{ Auth::user()->userable->NOMBRE }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    @endauth
    

    @yield('contenido')



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/natural.js"></script>

    <script>
        function showLoading() {
            document.querySelector('#loading').classList.add('loading');
            document.querySelector('#loading-content').classList.add('loading-content');
        }

        function hideLoading() {
            document.querySelector('#loading').classList.remove('loading');
            document.querySelector('#loading-content').classList.remove('loading-content');
        }

    </script>

    @yield('js')
</body>
</html>
