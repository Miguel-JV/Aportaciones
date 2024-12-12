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
    @if ($ticket->ESTATUS_AUTORIZACION == 'SI' || $ticket->REINCIDENCIA == 'SI' || $ticket->AREA_RESPONSABLE == 'SEDENA' || $ticket->AREA_RESPONSABLE == 'SEMAR' || $ticket->DAÑO == 'Siniestro - Temblor' || $ticket->DAÑO == 'Siniestro - Desastre Meteorilógico')
        <div class="container form-container">
            <div class="form-header">
                <h2>Actualizar Ticket</h2>
            </div>

            <form action=" {{ route('update.ticket', $ticket) }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf
                @method('PATCH')

                <div class="form-row justify-content-center">

                    <div class="form-group col-md-6">
                        <label for="fecha_termino">Fecha Actualizacion</label>
                        <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{ date("Y-m-d") }}" min="2010-01-01" max="{{ date("Y-m-d") }}" required>
                    </div>



                    <div class="form-group col-md-6">
                        <label for="area_atendio">Area Atedió</label>
                        <select id="area_atendio" name="area_atendio" class="form-control" required>
                            <option value="{{ $ticket->AREA_RESPONSABLE }}">{{ $ticket->AREA_RESPONSABLE }}</option>

                            @foreach ($areas as $area)
                            <option value="{{ $area->NOMBRE }}">{{ $area->NOMBRE }}</option>
                            @endforeach

                        </select>
                    </div>

                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="persona_atendio">Persona Atendió</label>
                        <input type="text" class="form-control" id="persona_atendio" name="persona_atendio" placeholder="Ingrese el nombre" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="actualizar_estatus">Actualizar Estatus</label>
                        <select id="actualizar_estatus" name="actualizar_estatus" class="form-control" required>
                            <option value="" >{{ $ticket->ESTATUS_ACTUAL }}</option>

                            <option value="EN PROCESO">EN PROCESO</option>
                            <option value="FINALIZADO">FINALIZADO</option>
                        </select>

                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="observaciones_finales">Observaciones Finales</label>
                        <textarea id="observaciones_finales" name="observaciones_finales" class="form-control" rows="3" maxlength="100" placeholder="Max 100 caracteres" required></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="foto_obligatoria">Foto Evidencia Obligatoria</label>

                        <input id="foto_obligatoria" name="foto_obligatoria" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png"   required /> <br>
                        <label id="lbl_foto_obligatoria" for="foto_obligatoria" class="btn btn-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>

                        <br>
                        <label for="foto_obligatoria" class="file-note">Imagenes .jpg, .jpeg, .png, no mayores a 5MB </label>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="daño">Foto Evidencia Opcional</label>

                        <input id="foto_opcional_2" name="foto_opcional_2" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png" > <br>
                        <label for="foto_opcional_2" class="btn btn-outline-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="daño">Foto Evidencia Opcional</label>

                        <input id="foto_opcional_3" name="foto_opcional_3" type="file" style="display: none" onchange="cambiarContenido(this)" accept=".jpg, .jpeg, .png" > <br>
                        <label for="foto_opcional_3" class="btn btn-outline-info" onmouseover="asignarNombre(this)">Adjuntar Evidencia</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6" style="align-items: center;">
                        <label id="detalle" name="detalle" class="btn btn-outline-info btn-custom" data-toggle="modal" data-target="#modal">
                            Detalle
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary btn-custom" onclick="cambiarBG();">Guardar</button>
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
                                    <img id="myimage_1" data-id="myimage_1" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_OBLIGATORIA) }}" alt="Foto No Registrada" >
                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="foto_evidencia_1">Foto Evidencia</label><br>
                                <div class="img-zoom-container">
                                    <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_2)}}" alt="Foto No Registrada"  >
                                    <div id="myresult" class="img-zoom-result"></div>

                                </div>
                            </div>

                            <div class="form-group col-md-4">

                                <label for="foto_evidencia_1">Foto Evidencia</label><br>
                                <div class="img-zoom-container">
                                    <img id="myimage_3" data-id="myimag_3" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_3)}}" alt="Foto No Registrada"  >
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>



    @elseif ($ticket->ESTATUS_AUTORIZACION == 'NO')
        <div class="container form-container">
            <div class="form-header">
                <h2>Actualizar Ticket</h2>
                <h3>Ticket NO Autorizado</h3>

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
        let inputFotoObligatoria = document.getElementById('foto_obligatoria');
        let lblFotoObligatoria = document.getElementById('lbl_foto_obligatoria');
        if (inputFotoObligatoria.value == ""){
            lblFotoObligatoria.className = 'btn btn-warning';
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
@endsection
