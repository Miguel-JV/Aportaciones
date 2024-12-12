{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Cotizar Ticket
@endsection

@section('css')
    <style>
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
            margin-top: 7%;
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
            width: 500px;
            height: 310px;
            position: absolute;
            top: -380px;
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
                    <h3>No se permiten más cotizaciones</h3>

                </div>
            </div>
        @else
            <div class="container form-container ">
                <div class="form-header">
                    <h1>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h1>
                    <h2> Modificar Cotizacion</h2>
                    <h3>{{ $decrypted }} </h3>
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
                            <input type="date" class="form-control" id="fecha_compromiso" name="fecha_compromiso" value="{{ date("Y-m-d") }}" min="{{ date("Y-m-d") }}"  required>
                        </div>
                    </div>


                    <div class="form-row">

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_1" data-id="myimage_1" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_OBLIGATORIA) }}" >
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_2) }}" >

                                {{-- Imagen de Acercamiento --}}
                                <div id="myresult" class="img-zoom-result"></div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_3" data-id="myimag_3" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_3) }}" >
                            </div>
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

                    <div class="form-row justify-content-center" style="text-align: center">
                        <div class="form-group col-md-9">

                            <label for="justificacion" >Justificacion de Modificación</label>
                            <textarea class="form-control" name="justificacion" id="justificacion" rows="3" maxlength="100" placeholder="Max 100 Caracteres" required></textarea>
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
        @endif


@endsection


@section('js')
    <script>
        let labelArchivo = '';

        function asignarNombre(lbl) {
            labelArchivo = lbl;
        }

        function cambiarContenido(inputArchivo) {

            let nombreArchivo = inputArchivo.value;
            let idExtencion = nombreArchivo.lastIndexOf(".") + 1;
            let extArchivo = nombreArchivo.substr(idExtencion, nombreArchivo.length).toLowerCase();

            if (extArchivo=="docx" || extArchivo=="pdf" ||extArchivo=="xlsx"){

                let nombreArchivo = inputArchivo.files[0].name;
                if (inputArchivo.value != "") {
                    labelArchivo.innerHTML = nombreArchivo;
                    labelArchivo.className = 'btn btn-success'

                }

            }else{
                inputArchivo.value = "";
                labelArchivo.className = 'btn btn-outline-warning'
                labelArchivo.innerHTML = "Adjuntar Formato docx, pdf, xlsx";

            }
        }
    </script>

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
            console.log(item.id)
            // Initiate zoom effect:
            imageZoom(item.id, "myresult");
        });
    </script>

@endsection
