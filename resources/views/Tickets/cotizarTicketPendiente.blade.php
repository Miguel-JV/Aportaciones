{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Actualizar Ticket
@endsection

@section('css')
    <style>
        /* img:hover{
            transform: scale(1.07);
            transition: 0.3s ease-in-out;
        } */

        .container {
            max-width: 90%;
            /* margin: 50px auto; */
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        .file-note{
            color: gray;
            font-style:italic;
            font-family: cursive;
        }

    </style>

    {{-- ADICIONES --}}
    {{-- Zoom 2 --}}
    <style>
        .container {
            margin-top: 60px;
        }
        .img-zoom-container {
            display: block;
            position: relative;
            width: 100%;
            height: auto;
        }

        .img-zoom-lens {
            position: absolute;
            /*set the size of the lens:*/
            width: 100px;
            height: 100px;
        }

        .img-zoom-lens:hover {
            border: 1px solid #cccccc;
        }

        .item-img {

            /* box-shadow: -1px -1px 6px 0 rgb(122, 221, 102), 4px 4px 4px 4px rgb(92, 162, 235); */
        }

        .img-zoom-result {
            visibility: hidden;

            border: 1px solid #d4d4d4;
            /*set the size of the result div:*/
            width: 450px;
            height: 310px;
            position: absolute;
            top: -380px;
            left: -150px;
            border-radius: 10px;
            overflow: hidden;

            box-shadow: 12px 12px 0px rgba(0, 0, 0, 0.1);
        }


    </style>
@endsection


@section('contenido')
        <div class="container form-container mt-5 ">
            <div class="form-header">
                <h1>{{ $decrypted }}</h1>
                <h2>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h2>
                <h3>{{ $ticket->FECHA_INICIO }} </h3>
            </div>

            <form action=" {{ route('quote.ticket',
                [
                    'ticket' => $ticket,
                    'usuario' => $decrypted,
                ])
            }}" enctype="multipart/form-data" method="POST" onsubmit="showLoading()"  >

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf
                @method('PATCH')

                <div class="form-row mt-5">
                    <div class="form-group col-md-6">
                        @if ($ticket->AREA_RESPONSABLE == 'Publicidad' || $ticket->AREA_RESPONSABLE == 'PEMSA - Seguridad Industrial' || $ticket->AREA_RESPONSABLE == 'FYCSA')
                        <label for="monto" style="color: #ffc107;">Monto Aproximado Opcional ($MXN)</label>
                        <input type="number"  class="form-control" id="monto" name="monto" min="0.00"  step="0.01" placeholder="0.00"/>

                        @else
                        <label for="monto">Monto Aproximado ($MXN)</label>
                        <input type="number"  class="form-control" id="monto" name="monto" min="0.00"  step="0.01" placeholder="0.00" required/>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fecha_compromiso">Fecha Compromiso</label>
                        <input type="date" class="form-control" id="fecha_compromiso" name="fecha_compromiso"  min="{{ date("Y-m-d") }}"  >
                    </div>
                </div>

                <div class="form-row justify-content-center">
                    <div class="form-group col-md-6">

                        <input id="archivo_opcional" name="archivo_opcional" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".docx, .pdf, .xlsx"  /> <br>
                        <label id="lbl_archivo_opcional" for="archivo_opcional" class="btn btn-outline-warning" onmouseover="asignarNombre(this)">Adjuntar Documento Opcional</label>

                        <br>
                        <label for="archivo_pago" class="file-note" >Archivos .docx, .pdf, .xlsx</label>
                    </div>

                    <div class="form-group col-md-4" style="align-items: center;">
                        <label for="detalle"></label>

                        <label id="detalle" name="detalle" class="btn btn-outline-info btn-custom" data-toggle="modal" data-target="#modal">
                            Detalle
                        </label>
                    </div>
                </div>


                <div class="form-row">


                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-success btn-custom">Guardar Cotización</button>
                    </div>

                    <div class="form-group col-md-6">
                        <a  class="btn btn-danger btn-custom" href="{{ route('consultar.ticket') }}">Cancelar Cotización</a>
                    </div>

                </div>

            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade " id="modal" tabindex="-1" role="dialog" aria-labelledby="tituloModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModalCentrado">Detalle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="casa">Area</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->AREA_RESPONSABLE }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="casa">Afección</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->AFECCION }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="casa">Sitio</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->SITIO }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="casa">Espacio</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->ESPACIO }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="casa">Objeto</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->OBJETO }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="casa">Elemento</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->ELEMENTO }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="descripcion_concreta">Descripción Concreta</label>
                                <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="4" maxlength="100" placeholder="{{ $ticket->DETALLE }}" readonly></textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
@endsection


@section('js')

    <script>
        // MODIFICACION DE ELEMENTOS INPUT FILE
        let labelArchivo = '';

        function asignarNombre(lbl) {
            labelArchivo = lbl;
        }

        function cambiarContenido(inputArchivo) {

            let nombreArchivo = inputArchivo.value;
            let idExtencion = nombreArchivo.lastIndexOf(".") + 1;
            let extArchivo = nombreArchivo.substr(idExtencion, nombreArchivo.length).toLowerCase();

            if ( extArchivo=="pdf" || extArchivo=="xlsx" || extArchivo=="docx" || extArchivo=="png" || extArchivo=="jpg" || extArchivo=="jpeg"){

                let nombreArchivo = inputArchivo.files[0].name;
                if (inputArchivo.value != "") {
                    labelArchivo.innerHTML = nombreArchivo;
                    labelArchivo.className = 'btn btn-success'

                }

            }else{
                inputArchivo.value = "";
                labelArchivo.className = 'btn btn-outline-danger'
                labelArchivo.innerHTML = "Formato no reconocido";

            }
        }

        function cambiarBG(){
            let inputArchivoPago = document.getElementById('archivo_pago');
            let lblinputArchivoPago = document.getElementById('lbl_archivo_pago');
            if (inputArchivoPago.value == ""){
                lblinputArchivoPago.className = 'btn btn-warning';
            }
        }
    </script>
@endsection
