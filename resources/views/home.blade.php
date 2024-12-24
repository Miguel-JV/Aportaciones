@extends('layouts.home')

@section('title')
    Panel
@endsection

@section('contenido')

    <div class="cards container mt-5">

        @if (Auth::user()->rol == 'coordinador')
            <a href="{{ route('consultar.ticket') }}" class="card mantenimientos">
                <p class="tip">Mantenimientos</p>
                <p class="second-text"><i class="fa-solid fa-screwdriver-wrench"></i></p>
            </a>

            <a href="{{ route('consultar.ticket') }}" class="card tutorias">
                <p class="tip">Tutorias</p>
                <p class="second-text"><i class="fa-solid fa-user-pen"></i></i></p>
            </a>

            <a href="{{ route('consultar.ticket') }}" class="card mobiliario">
                <p class="tip">Mobiliario</p>
                <p class="second-text"><i class="fa-solid fa-truck-moving"></i></p>
            </a>
        @elseif(Auth::user()->rol == 'director')
            <a href="{{ route('consultar.ticket') }}" class="card" style="background-color: #007ced">
                <p class="tip">Mantenimientos</p>
                <p class="second-text"><i class="fa-solid fa-screwdriver-wrench"></i></p>
            </a>
        @endif

    </div>
@endsection
