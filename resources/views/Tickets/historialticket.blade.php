@extends('layouts.tickets')


@section('title')
    Historico Ticket

@endsection

@section('css')
    <style>
        .container {
            max-width: 90%;
            margin-top: 5%;
            align-items: center;
            /* margin: 50px auto; */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(103, 103, 103, 0.1);

        }

        .notificacion {
            /* width: 100%; */
            max-width: 90%;
            height: 70px;
            background: #cdcdcd74;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: left;
            backdrop-filter: blur(10px);
            transition: 0.5s ease-in-out;


            justify-content: center;
            margin-left: 5%;
        }

        .notificacion:hover {
            /* cursor: pointer; */
            transform: scale(1.05);
        }

        .imagen {
            width: 50px;
            height: 50px;
            margin-left: 10px;
            border-radius: 10px;
            background: linear-gradient(#c2c2c2ad, #a9a9a9);

            text-align:center;
        }

        .notificacion:hover > .imagen {
            transition: 2.0s ease-in-out;
            background: linear-gradient(#d7cfcfad, #393939);
        }

        .cajaTexto {
            width: calc(100% - 90px);
            margin-left: 10px;
            color: white;
            font-family: 'Poppins' sans-serif;

            margin-top: 1%;
            color: black;

        }

        .textoContenido {
                display: flex;
                align-items: center;
                justify-content: space-between;
        }

        .fecha {
            font-size: 10px;
        }

        .tipo {
            font-size: 16px;
            font-weight: bold;
        }

        .responsable {
            font-size: 12px;
            font-weight: lighter;
        }

    </style>
@endsection


@section('contenido')
    <div class="container form-container ">
        <div class="form-header">
            <h2 style="margin-bottom: 5%;">Modificaciones Realizadas</h2>

        </div>

        @foreach ($modificaciones as $modificacion)

            <div class="notificacion">
                <div class="imagen" >

                    <i class=" fa-solid fa-clock-rotate-left fa-xl" style="margin-top: 50%; color:white;"></i>
                </div>
                <div class="cajaTexto">
                    <div class="textoContenido">
                        <p class="tipo">{{ $modificacion->TIPO }} - {{ $modificacion->RESPONSABLE }}</p>
                        <span class="fecha">{{ $modificacion->FECHA }}</span>
                    </div>
                    @if (is_null($modificacion->JUSTIFICACION))
                        <p class="responsable"> --- </p>
                    @else
                        <p class="responsable">{{ $modificacion->JUSTIFICACION }}  </p>
                    @endif
                </div>
            </div>
            <br>
        @endforeach

        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-outline-dark ">
            <i class="fa-solid fa-chevron-left"></i>
        </a>


    </div>
@endsection


@section('js')


@endsection
