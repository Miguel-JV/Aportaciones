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

    <style>
        .cards a{
            text-decoration: none;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: center;
        }

        .cards .card {
            background-color: rgba(255, 255, 255, 0.1);

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;

            flex: 0 0 1;

            height: 150px;
            width: 100%;

            border-radius: 10px;
            color: black;
            cursor: pointer;

            transition: 400ms transform, 400ms box-shadow, 400ms background-color;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .cards .card p.tip {
            font-size: 1em;
            font-weight: 700;
        }

        .cards .card p.second-text {
            font-size: 2em;
        }

        .cards .card:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
            background-color: rgba(255, 255, 255, 0.1);
            color: #333;
        }

        .cards .mantenimientos:hover {
            transform: scale(1.1);
            background-color: #007ced;
            color: white;
        }

        .cards:hover > .card:not(:hover) {
            filter: blur(10px);
            transform: scale(0.9);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        @media screen and (min-width: 768px) {
            .cards .card {
                width: calc(100% / 4);
            }
        }
    </style>
</head>
<body>

    {{-- BARRA DE NAVEGACIÓN --}}
    @auth
        <ul class="nav nav-tabs justify-content-center">

            {{-- USUARIO --}}
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->rol }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    @endauth

    @yield('contenido')

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
