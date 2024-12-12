@extends('layouts.tickets')

@section('title')
    Generar Consulta
@endsection

@section('css')

@endsection


@section('contenido')
        

        <div class="container form-container mt-5" style="width: 50%;">
            <div class="form-header">
                <h2>Generar Consulta</h2>
            </div>


            <form action=" {{ route('consult.ticket') }}" method="POST">
            {{-- <form> --}}

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $startWeek }}" min="2010-01-01"  required>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="fecha_termino">Fecha Terminacion</label>
                        <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{ $now }}" min="2010-01-01"  required> {{-- max="{{ date("Y-m-d") }}" --}}
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Descargar</button>
            </form>


        </div>

@endsection


@section('js')

@endsection
