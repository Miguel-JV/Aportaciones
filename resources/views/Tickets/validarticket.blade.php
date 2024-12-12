{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Validar Ticket
@endsection

@section('css')
    <style>

        /* Zoom 1 */
        .container-enlarge {
            display: inline-block;
            position: relative;
        }
        .container-enlarge > img {
            height: auto;
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
        }
        .container-enlarge span {
            position: absolute;
            top: -9999em;
            left: -9999em;
        }
        .container-enlarge:hover span {
            top: -500px;
            left: -200px;
            width: 650px;
        }

        /* ADICIONES */
        /* Zoom 2 */
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
            height: 350px;
            position: absolute;
            top: -500px;
            left: -100px;
            border-radius: 10px;
            overflow: hidden;

            box-shadow: 12px 12px 0px rgba(0, 0, 0, 0.1);
        }

        .container {
            /* margin-top: 60px; */
        }

    </style>
@endsection


@section('contenido')

    @if ($validado)

        <div class="container form-container">
            <div class="form-header">
                <h2>Validar Ticket</h2>
                <h3>Ticket validado por {{ $ultimaValidacion->RESPONSABLE }} - {{ $ultimaValidacion->FECHA }}</h3>

                <div class="form-row justify-content-center" >
                    <div class="form-group col-md-4">
                        <a href="{{ route('consultar.ticket') }}">
                            <label class="btn btn-outline-danger btn-custom">
                                Validación no Disponible
                            </label>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    @else

        <div class="container form-container" >
            <div class="form-header">
                <h2>{{ $ticket->CASA }} - {{ $ticket->FOLIO }}</h2>
                <h3>{{ $ticket->FECHA_INICIO }} </h3>
            </div>
    {{--  $ticket, $encargado --}}
            <form action=" {{ route('validate.ticket',
                    [
                        'ticket' => $ticket,
                        'usuario' => $encargado,
                    ]) }}" method="POST" onsubmit="showLoading()" >

                {{-- Redireccionar a rutas de actualizacion  --}}
                @csrf
                @method('PATCH')

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="area">Area</label>
                        <input type="text" class="form-control" id="area" name="area" value="{{ $ticket->AREA_RESPONSABLE }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="afeccion">Afección</label>
                        <input type="text" class="form-control" id="afeccion" name="afeccion" value="{{ $ticket->AFECCION }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="sitio">Sitio</label>
                        <input type="text" class="form-control" id="sitio" name="sitio" value="{{ $ticket->SITIO }}" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="espacio">Espacio</label>
                        <input type="text" class="form-control" id="espacio" name="espacio" value="{{ $ticket->ESPACIO }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="objeto">Objeto</label>
                        <input type="text" class="form-control" id="objeto" name="objeto" value="{{ $ticket->OBJETO }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="elemento">Elemento</label>
                        <input type="text" class="form-control" id="elemento" name="elemento" value="{{ $ticket->ELEMENTO }}" readonly>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="descripcion_concreta">Descripción Concreta</label>
                        <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="2" maxlength="100" placeholder="{{ $ticket->DETALLE }}" readonly></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="actualizar_prioridad">Actualizar Prioridad</label>
                        <select id="actualizar_prioridad"  name="actualizar_prioridad" class="form-control" required>
                            <option value="{{ $ticket->PRIORIDAD }}">{{ $ticket->PRIORIDAD }}</option>

                            @foreach ($prioridades as $prioridad)
                                <option value="{{ $prioridad->NOMBRE }}"> {{ $prioridad->NOMBRE }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group col-md-6">
                        <label for="actualizar_nivel">Nivel Notificación</label>
                        <select id="actualizar_nivel" onchange="cargarEncargados(this)" name="actualizar_nivel" class="form-control" required>
                            <option value="">Seleccionar un nivel de notificación...</option>

                            <option value="SUPERVISION"> SUPERVISION</option>
                            <option value="SUBGERENCIA"> SUBGERENCIA</option>
                            <option value="GERENCIA"> GERENCIA</option>
                        </select>

                    </div>
                </div>

                <div class="form-row">
                    <h4 class="form-group col-md-12" style="text-align: center">Personal a Notificar</h4>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="supervisor">Supervisor</label>
                        <input type="text" class="form-control" id="supervisor" name="supervisor"  value="{{ $ticket->SUPERVISOR }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="subgerente">Subgerente</label>
                        <input type="text" class="form-control" id="subgerente" name="subgerente" value="{{ $ticket->SUBGERENTE }}" style="display: none" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gerente">Gerente</label>
                        <input type="text" class="form-control" id="gerente" name="gerente" value="{{ $ticket->GERENTE }}" style="display: none" readonly>
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
                            <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_2) }}" width="auto" height="290">
                            {{-- Imagen de Acercamiento --}}
                            <div id="myresult" class="img-zoom-result"></div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">

                        <label for="foto_evidencia_1">Foto Evidencia</label><br>
                        <div class="img-zoom-container">
                            <img id="myimage_3" data-id="myimage_3" class="item-img img-fluid img-thumbnail" src="{{ asset($strroute .'inicio/'. $ticket->FOTO_3) }}" width="auto" height="290">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-info btn-custom">Validar</button>
                    </div>
                    <div class="form-group col-md-6">
                        <label id="cancelar" class="btn btn-outline-danger btn-custom" data-toggle="modal" data-target="#modal" data-casa="{{ $ticket->casa}}" >Cancelar</label>
                    </div>
                </div>

            </form>
        </div>

        {{-- MODAL --}}
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_titulo">Fallo al obtener casa tutora</h5>
                    </div>
                    <div class="modal-body">

                        <div class="container form-container">
                            <form action=" {{ route('cancel.ticket', $ticket) }}" method="POST">
                                {{-- Redireccionar a rutas de controlador  --}}
                                @csrf

                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label for="mensaje" class="col-form-label">Mensaje:</label>
                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="3" maxlength="200" placeholder="Max 200 caracteres" required>
                                        </textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Enviar</button>
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
    <script>

        function cargarEncargados(inputNivel){
            let inputsubgerente = document.getElementById('subgerente');
            let inputgerente = document.getElementById('gerente');

            switch (inputNivel.value) {
                case 'GERENCIA':
                    inputsubgerente.style.display = 'block';
                    inputgerente.style.display = 'block';
                    break;

                case 'SUBGERENCIA':
                    inputsubgerente.style.display = 'block';
                    inputgerente.style.display = 'none';
                    break;

                case 'SUPERVISION':
                    inputsubgerente.style.display = 'none';
                    inputgerente.style.display = 'none';
                break;

            }
        }

        function cargar() {
            let prioridad = document.getElementById('actualizar_nivel');
            cargarEncargados(prioridad);
        }

        window.onload = cargar;
    </script>

    {{-- MODAL --}}
    <script>
        $('#modal').on('show.bs.modal', function (event) {
            const linkModal = $(event.relatedTarget);
            const modal = $(this);
            let mensaje = "Observacion a casa " + linkModal.data('casa').NOMBRE ;

            modal.find('#modal_titulo').html(mensaje);
            modal.find('#modal_titulo').html(mensaje);

        });

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

            // console.log("result.offsetWidth:" + result.offsetWidth + "lens.offsetWidth:" + lens.offsetWidth);

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
