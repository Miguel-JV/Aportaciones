{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Actualizar Ticket
@endsection

@section('css')
    <style>
        .container {
            max-width: 90%;
            /* margin: 50px auto; */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

            margin-top: 10%;
        }

    </style>

@endsection


@section('contenido')

        @if ($ticket->FOTO_OBLIGATORIA == NULL)
            <div class="container form-container">
                <div class="form-header">
                    <h2>Actualizar Evidencias Ticket</h2>
                    <h3>{{$ticket->FOLIO}}</h3>
                </div>

                <form action=" {{ route('update.ticket.past', $ticket) }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">

                    {{-- Redireccionar a rutas de actualizacion  --}}
                    @csrf
                    @method('PATCH')

                    <div class="form-row" style="text-align:center;">

                        @if ($ticket->ESTATUS_ACTUAL == 'FINALIZADO')
                            <div class="form-group col-md-6">
                                <label for="foto_inicio">Foto Evidencia Inicio</label>

                                <input id="foto_inicio" name="foto_inicio" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png"   required /> <br>
                                <label id="lbl_foto_inicio" for="foto_inicio" class="btn btn-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>

                                <br>
                                <label for="foto_inicio" class="file-note">Imagenes .jpg, .jpeg, .png, no mayores a 5MB </label>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="foto_fin">Foto Evidencia Fin</label>

                                <input id="foto_fin" name="foto_fin" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png"   required /> <br>
                                <label id="lbl_foto_fin" for="foto_fin" class="btn btn-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>

                                <br>
                                <label for="foto_fin" class="file-note">Imagenes .jpg, .jpeg, .png, no mayores a 5MB </label>
                            </div>

                        @else
                            <div class="form-group col-md-12">
                                <label for="foto_inicio">Foto Evidencia Inicio</label>

                                <input id="foto_inicio" name="foto_inicio" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png"   required /> <br>
                                <label id="lbl_foto_inicio" for="foto_inicio" class="btn btn-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>

                                <br>
                                <label for="foto_inicio" class="file-note">Imagenes .jpg, .jpeg, .png, no mayores a 5MB </label>
                            </div>
                        @endif
                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-custom" onclick="cambiarBG();">Guardar</button>
                        </div>

                    </div>

                </form>
            </div>
        @else
            <div class="container form-container">
                <div class="form-header">
                    <h2>Actualizar Evidencias Ticket</h2>
                    <h3>Ticket Actualizado</h3>

                    <div class="form-row justify-content-center" >
                        <div class="form-group col-md-4">
                            <a href="{{ redirect()->getUrlGenerator()->previous() }}">
                                <label class="btn btn-outline-danger btn-custom">
                                    Actualizacion no Disponible
                                </label>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endif




@endsection


@section('js')
    {{-- EVIDENCIAS DE TERMINO --}}
    <script>
        function asignarNombre(lbl) {
            labelArchivo = lbl;
        }


        function cambiarContenido(inputArchivo) {
            // Tamaño maximo del archivo
            let maxSize = 5000000; //5mb -> 5,000,000
            //let maxSize = 300000;//300kb

            // Validamos el primer archivo únicamente
            let archivo = inputArchivo.files[0];
            let nombreArchivo = inputArchivo.value;
            let idExtencion = nombreArchivo.lastIndexOf(".") + 1;
            let extArchivo = nombreArchivo.substr(idExtencion, nombreArchivo.length).toLowerCase();

            if (extArchivo=="jpg" && archivo.size <= maxSize|| extArchivo=="jpeg" && archivo.size <= maxSize|| extArchivo=="png" && archivo.size <= maxSize){

                let nombreArchivo = inputArchivo.files[0].name;
                if (inputArchivo.value != "") {
                    labelArchivo.innerHTML = nombreArchivo;
                    labelArchivo.className = 'btn btn-success'

                }

            }else{
                inputArchivo.value = "";
                labelArchivo.className = 'btn btn-outline-danger'
                labelArchivo.innerHTML = "Adjuntar jpg,jpeg,png - 5Mb máximo";

            }
        }

        function cambiarBG(){
        let inputFotoInicio = document.getElementById('foto_inicio');
        let lblFotoInicio = document.getElementById('lbl_foto_inicio');

        let inputFotoFin= document.getElementById('foto_fin');
        let lblFotoFin = document.getElementById('lbl_foto_fin');

        if (inputFotoInicio.value == ""){
            lblFotoInicio.className = 'btn btn-warning';
        }

        if (inputFotoFin.value == ""){
            lblFotoFin.className = 'btn btn-warning';
        }
    }
    </script>



@endsection
