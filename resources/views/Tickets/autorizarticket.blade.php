@extends('layouts.tickets')


@section('title')
    Autorizar Ticket
@endsection

@section('css')
    <style>
        .container{
            margin-top: 60px;
        }

        body{
            background-color: #ededed;
        }

        .file-note{
            color: gray;
            font-style:italic;
            font-family: cursive;
        }

    </style>

    {{-- Zoom 2 --}}
    <style>

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
            width: 500px;
            height: 310px;
            position: absolute;
            top: -350px;
            left: -100px;
            border-radius: 10px;
            overflow: hidden;

            box-shadow: 12px 12px 0px rgba(0, 0, 0, 0.1);
        }


    </style>
@endsection


@section('contenido')
    @if ($ticket->ESTATUS_AUTORIZACION == 'SI')
        <div class="container form-container">
            <div class="form-header">
                <h1>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h1>
                <h2>TICKET AUTORIZADO</h2>
                <h3>No se permiten más autorizaciones.</h3>

                <div class="form-row justify-content-center">
                    <div class="form-group col-md-4 mt-5">
                        @if (!is_null($ticket->ARCHIVO_AUTORIZACION))

                            <a href="{{ route('exportar.autorizacion',
                                [
                                    'nombre' =>$ticket->ARCHIVO_AUTORIZACION,
                                ]) }}">
                                <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-success btn-custom">
                                    Archivo de Autorización
                                </label>
                            </a>
                        @else
                                <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-warning btn-custom">
                                    Archivo de Autorización - No Disponible
                                </label>
                        @endif

                    </div>
                </div>

            </div>


        </div>
    @elseif($ticket->ESTATUS_AUTORIZACION == 'ANULADO')
        <div class="container form-container">
            <div class="form-header">
                <h1>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h1>
                <h2>TICKET NO AUTORIZADO</h2>
                <h3>No se permiten más autorizaciones.</h3>

            </div>


        </div>
    @elseif($ticket->ESTATUS_AUTORIZACION == 'NO')
        <div class="container form-container" >
            <div class="form-header">
                <h1>Autorizar Ticket</h1><br>
                <h2>{{ $decrypted }}</h2>
                <h3>{{ $ticket->CASA }} - {{ $ticket->FOLIO }} - {{ $ticket->FECHA_INICIO }}</h3>
            </div>

            <form action=" {{ route('authorize.ticket',
                    [
                        'ticket' => $ticket,
                        'usuario' => $decrypted,
                    ])
                }}" enctype="multipart/form-data" method="POST" onsubmit="showLoading()"  >

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf
                @method('PATCH')

                <div class="form-row d-flex justify-content-between" style="text-align: center;">

                    <div class="form-group col-md-3" style="align-items: center;">
                        @if (!is_null($ticket->ARCHIVO_COTIZACION))
                            <label for="archivo_adjunto">Archivo de Cotización</label>

                            <a href="{{ route('exportar.cotizacion',
                                [
                                    'nombre' =>$ticket->ARCHIVO_COTIZACION,
                                ]) }}">
                                <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-success btn-custom">
                                    Descargar
                                </label>
                            </a>
                        @else
                            <label for="archivo_adjunto">Archivo de Cotización</label>

                                <label id="archivo_adjunto" name="archivo_adjunto" class="btn btn-outline-warning btn-custom">
                                    No Disponible
                                </label>
                        @endif

                    </div>

                    <div class="form-group col-md-3">
                        @if ($ticket->AREA_RESPONSABLE == 'Publicidad' || $ticket->AREA_RESPONSABLE == 'PEMSA - Seguridad Industrial' || $ticket->AREA_RESPONSABLE == 'FYCSA')
                            <input id="archivo_firmado" name="archivo_firmado" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".xlsx, .pdf"    /> <br>
                            <label id="lbl_archivo_firmado" for="archivo_firmado" class="btn btn-outline-warning" onmouseover="asignarNombre(this)">Adjuntar Documento Opcional</label>
                            <br>
                            <label for="archivo_pago" class="file-note" >Archivos .xlsx, .pdf</label>

                        @else

                            <input id="archivo_firmado" name="archivo_firmado" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".xlsx, .pdf"   required  /> <br>
                            <label id="lbl_archivo_firmado" for="archivo_firmado" class="btn btn-outline-dark" onmouseover="asignarNombre(this)">Adjuntar Documento Autorizacion</label>
                            <br>
                            <label for="archivo_pago" class="file-note" >Archivos .xlsx, .pdf</label>

                        @endif
                    </div>

                    <div class="form-group col-md-3" style="align-items: center;">
                        <label for="detalle">Detalle</label>

                        <label id="detalle" name="detalle" class="btn btn-outline-info btn-custom" data-toggle="modal" data-target="#modal">
                            <i class="fa-regular fa-eye"></i>
                        </label>
                    </div>

                </div>


                <div class="form-row mt-5">

                    <div class="form-group col-md-4">

                        <label for="foto_evidencia_1">Foto Evidencia</label><br>
                        <div class="img-zoom-container">
                            <img id="myimage_1" data-id="myimage_1" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute . $ticket->FOTO_OBLIGATORIA) }}" >
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        <label for="foto_evidencia_1">Foto Evidencia</label><br>
                        <div class="img-zoom-container">
                            <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute . $ticket->FOTO_2) }}" >

                            {{-- Imagen de Acercamiento --}}
                            <div id="myresult" class="img-zoom-result"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        <label for="foto_evidencia_1">Foto Evidencia</label><br>
                        <div class="img-zoom-container">
                            <img id="myimage_3" data-id="myimag_3" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute . $ticket->FOTO_3) }}" >
                        </div>
                    </div>

                </div>


                <div class="form-row justify-content-center" >


                    <div class="form-group col-md-3">
                        <label id="cancelar" class="btn btn-outline-danger btn-custom" data-toggle="modal" data-target="#modal-cancelacion" data-encargado="{{$decrypted}}" >Cancelar</label>
                    </div>
                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-success btn-custom"  onclick="cambiarBG()" >Autorizar</button>
                    </div>
                </div>

            </form>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Detalles</h5>
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
                            <div class="form-group col-md-6">
                                <label for="afeccion">Afección</label>
                                <textarea id="afeccion" name="afeccion" class="form-control" rows="2" maxlength="100" placeholder="{{ $ticket->AFECCION }}" readonly></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="descripcion_concreta">Descripción Concreta</label>
                                <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="2" maxlength="100" placeholder="{{ $ticket->DETALLE }}" readonly></textarea>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- MODAL CANCELACION --}}
        <div class="modal fade" id="modal-cancelacion" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_cancelacion_titulo">Fallo al obtener nombre</h5>
                    </div>
                    <div class="modal-body">

                        <div class="container form-container" style="margin-top:10px;";>
                            <form action=" {{ route('invalidate.ticket',[
                                'ticket' => $ticket,
                                'usuario' => $decrypted
                                ]) }}" method="POST">
                                {{-- Redireccionar a rutas de controlador  --}}
                                @csrf

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label for="mensaje" class="col-form-label">Mensaje:</label>
                                        <input class="form-control" id="mensaje" name="mensaje" rows="3" maxlength="300" placeholder="Max 300 caracteres" required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary" >Enviar</button>
                                </div>
                            </form>
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
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;
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
    {{-- MODAL CANCELACION --}}
    <script>
        $('#modal-cancelacion').on('show.bs.modal', function (event) {
            const linkModal = $(event.relatedTarget);
            const modal = $(this);
            let mensaje = linkModal.data('encargado');

            modal.find('#modal_cancelacion_titulo').html(mensaje);

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

            if ( extArchivo=="pdf" || extArchivo=="xlsx"){

                let nombreArchivo = inputArchivo.files[0].name;
                if (inputArchivo.value != "") {
                    labelArchivo.innerHTML = nombreArchivo;
                    labelArchivo.className = 'btn btn-success'

                }

            }else{
                inputArchivo.value = "";
                labelArchivo.className = 'btn btn-outline-danger'
                labelArchivo.innerHTML = "Adjuntar Formato pdf, xlsx";

            }
        }

        function cambiarBG(){
            let inputFotoObligatoria = document.getElementById('archivo_firmado');
            let lblFotoObligatoria = document.getElementById('lbl_archivo_firmado');
            if (inputFotoObligatoria.value == ""){
                lblFotoObligatoria.className = 'btn btn-warning';
            }
        }
    </script>

@endsection
