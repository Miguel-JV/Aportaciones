{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Consultar Ticket
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

        }

        img:hover{
            cursor: pointer;
            transform: scale(1.07);
            transition: 0.8s ease-in-out;
        }


    </style>

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



    <div class="container mt-5">
        <h2 class="text-center mb-4 mt-2">Listado de Tickets</h2>
        <div class="table-responsive">
            <table id="ticketsTable" class="table table-striped table-bordered table-sm  table-hover" style="text-align:center;">
                <thead class="thead-dark ">
                    <tr>
                        {{-- <th class="dt-center">ID</th> --}}
                        <th class="dt-center">FOLIO</th>
                        <th class="dt-center">PRIORIDAD</th>
                        <th class="dt-center">FECHA</th>
                        <th class="dt-center">ESTATUS</th>

                        <th class="dt-center">DETALLE</th>

                        @if (Auth::user()->rol == 'director')
                            <th class="dt-center">ACTUALIZAR</th>
                        @endif

                        <th class="dt-center">ESTATUS PROCEDIMIENTOS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>

                            {{-- <td>{{ $ticket->ID_TICKET }}</td> --}}
                            <td>{{ $ticket->FOLIO }}</td>
                            <td>{{ $ticket->PRIORIDAD }}</td>
                            <td>{{ $ticket->FECHA_INICIO }}</td>
                            <td>{{ $ticket->ESTATUS_ACTUAL }}</td>

                            <td>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#detalleModal" data-ticket="{{ $ticket }}">
                                    <i class="fa-regular fa-folder-open"></i>
                                </button>
                            </td>

                            @if (Auth::user()->rol == 'director')
                                <td >
                                    @if($ticket->ESTATUS_ACTUAL == 'FINALIZADO'|| $ticket->ESTATUS_ACTUAL == 'CANCELADO' || $ticket->ESTATUS_AUTORIZACION == 'ANULADO')
                                        <button class="btn btn-outline-danger">
                                                <i class="fa-solid fa-ban"></i>
                                        </button>

                                    @elseif ($ticket->REINCIDENCIA == 'SI' || $ticket->AREA_RESPONSABLE == 'SEDENA' || $ticket->AREA_RESPONSABLE == 'SEMAR' || $ticket->DAÑO == 'Siniestro - Temblor' || $ticket->DAÑO == 'Siniestro - Desastre Meteorilógico')
                                        <a href="{{ route('actualizar.ticket', $ticket) }}" class="btn btn-outline-warning">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                                    @elseif ($ticket->ESTATUS_AUTORIZACION == 'SI')
                                        <a href="{{ route('actualizar.ticket', $ticket) }}" class="btn btn-outline-info">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                                    @elseif($ticket->ESTATUS_ACTUAL == 'PENDIENTE')
                                        <a href="{{ route('actualizar.ticket', $ticket) }}" class="btn btn-outline-warning">
                                                <i class="fa-solid fa-ban"></i>
                                        </a>

                                    @endif

                                </td>
                            @endif


                            <td>
                                <a href="{{ route('historial.ticket', $ticket) }}" class="btn btn-outline-dark">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="text-center">
            <a href="{{ route('crear.tickets') }}" class="btn btn-primary btn-custom-end-dataTable">
                <i class="fa-regular fa-square-plus"></i>
                Capturar Ticket
            </a>
        </div>

    </div>


    {{-- MODAL --}}
    <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">FOLIO TICKET</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="casa">Casa</label>
                            <input type="text" class="form-control" id="casa" name="casa" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="daño">Daño</label>
                            <input type="text" class="form-control" id="daño" name="daño" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="reincidencia">Reincidencia</label>
                            <input type="text" class="form-control" id="reincidencia" name="reincidencia" value="" readonly>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="area">Area</label>
                            <input type="text" class="form-control" id="area" name="area" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="afeccion">Afección</label>
                            <input type="text" class="form-control" id="afeccion" name="afeccion" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="sitio">Sitio</label>
                            <input type="text" class="form-control" id="sitio" name="sitio" value="" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="espacio">Espacio</label>
                            <input type="text" class="form-control" id="espacio" name="espacio" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="objeto">Objeto</label>
                            <input type="text" class="form-control" id="objeto" name="objeto" value="" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="elemento">Elemento</label>
                            <input type="text" class="form-control" id="elemento" name="elemento" value="" readonly>
                        </div>
                    </div>

                    <div class="form-row mt-5">

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_1" data-id="myimage_1" class="item-img img-fluid img-thumbnail" alt="Foto No Registrada" >
                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_2" data-id="myimage_2" class="item-img img-fluid img-thumbnail" alt="Foto No Registrada"  >
                                <div id="myresult" class="img-zoom-result"></div>

                            </div>
                        </div>

                        <div class="form-group col-md-4">

                            <label for="foto_evidencia_1">Foto Evidencia</label><br>
                            <div class="img-zoom-container">
                                <img id="myimage_3" data-id="myimag_3" class="item-img img-fluid img-thumbnail" alt="Foto No Registrada"  >
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descripcion_concreta">Descripción Concreta</label>
                            <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="4" maxlength="100" placeholder="" readonly></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('js')
    {{-- DATATABLE --}}
    <script>
        let tabla = new DataTable('#ticketsTable',{
            lengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, 'All']
            ],
            order: [[2, 'desc'], [0, 'desc']],
            columnDefs: [
                {
                type: 'natural',
                target: 0
                }
            ],


            "pagingType": "full_numbers",
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "paginate": {
                        "first": "<<",
                        "last": ">>",
                        "next": ">",
                        "previous": "<"
                    }
                }

        });
    </script>

    {{-- MODAL DETALLE --}}
    <script>
        //let strroute = 'storage/app/public/tickets/evidencias/'
        let strroute = 'storage/tickets/evidencias/'

        $('#detalleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)

            var ticket = button.data('ticket')

            var modal = $(this)

            modal.find('.modal-title').text(ticket.FOLIO)
            modal.find('.modal-body input#casa').val(ticket.CASA)
            modal.find('.modal-body input#daño').val(ticket.DAÑO)
            modal.find('.modal-body input#reincidencia').val(ticket.REINCIDENCIA)

            modal.find('.modal-body input#area').val(ticket.AREA_RESPONSABLE)
            modal.find('.modal-body input#afeccion').val(ticket.AFECCION)
            modal.find('.modal-body input#sitio').val(ticket.SITIO)
            modal.find('.modal-body input#espacio').val(ticket.ESPACIO)
            modal.find('.modal-body input#objeto').val(ticket.OBJETO)
            modal.find('.modal-body input#elemento').val(ticket.ELEMENTO)

            var source = `{!! asset('${strroute}inicio/${ticket.FOTO_OBLIGATORIA}') !!}`;
            modal.find('.modal-body img#myimage_1').attr('src', source);

            var source = `{!! asset('${strroute}inicio/${ticket.FOTO_2}') !!}`;
            modal.find('.modal-body img#myimage_2').attr('src', source);

            var source = `{!! asset('${strroute}inicio/${ticket.FOTO_3}') !!}`;
            modal.find('.modal-body img#myimage_3').attr('src', source);

            modal.find('.modal-body textarea#descripcion_concreta').val(ticket.DETALLE)
        })
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
