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
    @if ($ticket->ESTATUS_PAGO == 'SI')
        <div class="container form-container">
            <div class="form-header">
                <h1>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h1>
                <h2>TICKET PAGADO</h2>

                <div class="form-row justify-content-center" >
                    <div class="form-group col-md-4">
                        @if (!is_null($ticket->EVIDENCIA_PAGO))

                                <a href="{{ route('exportar.evidencia.pago',
                                    [
                                        'nombre' =>$ticket->EVIDENCIA_PAGO,
                                    ]) }}">
                                    <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-success btn-custom">
                                        Evidencia de Pago
                                    </label>
                                </a>
                        @else
                            <a href ="{{ redirect()->getUrlGenerator()->previous() }}">
                                <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-warning btn-custom">
                                    Evidencia de Pago - No Disponible
                                </label>
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    @elseif ($ticket->ESTATUS_ACTUAL == 'FINALIZADO' && $ticket->ESTATUS_PAGO == 'NO')
        <div class="container form-container">
            <div class="form-header">
                <h2>Actualizar Estatus Pago</h2>
                <h3> {{$ticket->FOLIO}}</h3>
            </div>

            <form action=" {{ route('update.ticket.finalized', $ticket) }}" method="POST" enctype="multipart/form-data">

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf
                @method('PATCH')

                <div class="form-row justify-content-center">

                    <div class="form-group col-md-12">
                        <label for="fecha_termino">Fecha Actualizacion</label>
                        <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{ date("Y-m-d") }}" min="2010-01-01" max="{{ date("Y-m-d") }}" required>
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="area_atendio">Area Atedió</label>
                        <input type="text" class="form-control" id="area_atendio" name="area_atendio" value="{{ $ticket->AREA_ATENCION }}" readonly>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="persona_atendio">Persona Atendió</label>
                        <input type="text" class="form-control" id="persona_atendio" name="persona_atendio" value="{{ $ticket->PERSONA_ATENCION }}" readonly>
                    </div>
                </div>

                <div class="form-row"  style="align-items: center;">

                    <div class="form-group col-md-6">
                        <label for="observaciones_finales">Observaciones Finales</label>
                        <textarea id="observaciones_finales" name="observaciones_finales" class="form-control" rows="3" placeholder="{{ $ticket->OBSERVACIONES }}" readonly></textarea>
                    </div>

                    <div class="form-group col-md-6">

                        {{-- <label for="observaciones_finales">Evidencia de Pago Opcional</label> --}}

                        <input id="archivo_pago" name="archivo_pago" type="file" style="display: none" onchange="cambiarContenido(this)"      /> <br>
                        <label id="lbl_archivo_pago" for="archivo_pago" class="btn btn-outline-warning" onmouseover="asignarNombre(this)">Adjuntar Documento Evidencia de Pago</label>

                        {{-- <br> --}}
                        <label for="archivo_pago" class="file-note">Formato opcional libre</label>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6" style="align-items: center;">
                        <label id="detalle" name="detalle" class="btn btn-outline-info btn-custom" data-toggle="modal" data-target="#modal">
                            Detalle
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-success btn-custom">Pagado</button>
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
                                <label for="ticket">Ticket</label>
                                <input type="text" class="form-control" id="ticket" name="ticket" value="{{ $ticket->FOLIO }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="fecha">Fecha Inicio</label>
                                <input type="text" class="form-control" id="fecha" name="fecha" value="{{ $ticket->FECHA_INICIO }}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="casa">Casa</label>
                                <input type="text" class="form-control" id="casa" name="casa" value="{{ $ticket->CASA }}" readonly>
                            </div>
                        </div>

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
                                <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="2" maxlength="100" placeholder="{{ $ticket->DETALLE }}" readonly></textarea>
                            </div>
                        </div>

                        <div class="form-row mt-5">

                            <div class="form-group col-md-4">

                                <label for="foto_evidencia_1">Foto Evidencia</label><br>
                                <div class="img-zoom-container">
                                    <img id="myimage_1" data-id="myimage_1" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'termino/'. $ticket->EVIDENCIA_TERMINO) }}" alt="Foto No Registrada" >
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="foto_evidencia_1">Foto Evidencia</label><br>
                                <div class="img-zoom-container">
                                    <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'termino/'. $ticket->EVIDENCIA_TERMINO_2)}}" alt="Foto No Registrada"  >
                                    <div id="myresult" class="img-zoom-result"></div>

                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="foto_evidencia_1">Foto Evidencia</label><br>
                                <div class="img-zoom-container">
                                    <img id="myimage_3" data-id="myimag_3" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'termino/'. $ticket->EVIDENCIA_TERMINO_3)}}" alt="Foto No Registrada"  >
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    @endif


@endsection


@section('js')

    {{-- ZOOM IMG --}}
    <script>
        function imageZoom(imgID, resultID) {
            let img, lens, result, cx, cy;
            img = document.getElementById(imgID);
            result = document.getElementById(resultID);
            /*create lens:*/
            lens = document.createElement("DIV");
            lens.setAttribute("class", "img-zoom-lens");
            /*insert lens:*/
            img.parentElement.insertBefore(lens, img);
            /*calculate the ratio between result DIV and lens:*/
            // cx = result.offsetWidth / (lens.offsetWidth);
            // cy = result.offsetHeight / (lens.offsetHeight);

            // PROPORCION MANUAL
            cx = 700 / 100;
            cy = 700 / 100;
            console.log("result.offsetWidth:" + result.offsetWidth + "lens.offsetWidth:" + lens.offsetWidth);
            console.log("cx:" + cx + "cy:" + cy);


            /*execute a function when someone moves the cursor over the image, or the lens:*/
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mousemove", moveLens);
            /*and also for touch screens:*/
            lens.addEventListener("touchmove", moveLens);
            img.addEventListener("touchmove", moveLens);

            // si sale del rango de la imagen
            lens.addEventListener("mouseleave", hide);
            img.addEventListener("mouseleave", hide);

            function moveLens(e) {
                let pos, x, y;
                /*set background properties for the result DIV:*/
                result.style.visibility = "visible";

                result.style.backgroundImage = "url('" + img.src + "')";
                result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
                /*prevent any other actions that may occur when moving over the image:*/
                e.preventDefault();
                /*get the cursor's x and y positions:*/
                pos = getCursorPos(e);
                /*calculate the position of the lens:*/
                x = pos.x - (lens.offsetWidth / 2);
                y = pos.y - (lens.offsetHeight / 2);

                /*prevent the lens from being positioned outside the image:*/
                if (x > img.width - lens.offsetWidth) {
                x = img.width - lens.offsetWidth;
                }
                if (x < 0) {
                x = 0;
                }
                if (y > img.height - lens.offsetHeight) {
                y = img.height - lens.offsetHeight;
                }
                if (y < 0) {
                y = 0;
                }
                /*set the position of the lens:*/
                lens.style.left = x + "px";
                lens.style.top = y + "px";
                /*display what the lens "sees":*/
                result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";

            }

            function getCursorPos(e) {
                let a, x = 0,
                y = 0;
                e = e || window.event;
                /*get the x and y positions of the image:*/
                a = img.getBoundingClientRect();
                /*calculate the cursor's x and y coordinates, relative to the image:*/
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /*consider any page scrolling:*/
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {
                x: x,
                y: y
                };
            }

            function hide(e){
                result.style.visibility = "hidden";
            }
        }

        let img = document.querySelectorAll('.item-img')
        img.forEach(function(item) {
            // Initiate zoom effect:
            imageZoom(item.id, "myresult");
        });
    </script>

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
