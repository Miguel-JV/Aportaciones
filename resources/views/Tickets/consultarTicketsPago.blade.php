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

        .btn-outline-custom-color, .btn-outline-custom-color:hover, .btn-outline-custom-color:active, .btn-outline-custom-color:visited {
            background-color: transparent !important;
            border-color: #24a464 !important;
            color: #24a464 !important;
        }

        .btn-outline-custom-color:hover{
            background-color: #24a464 !important;
            color: white !important;
        }


        .bg-subtitle-green {
            background-color: #198754;
        }

        .bg-subtitle-orange {
            background-color: #ff9823;
        }

        .centered{
            text-align: center;
        }
        .flex-centered{
            display: flex;
            justify-content: center;
        }
    </style>
@endsection


@section('contenido')


    {{-- Subtitulo FINALIZADOS--}}
    <div class="d-flex align-items-center p-3 my-3 text-white bg-subtitle-green  container rounded shadow-sm flex-centered" >
        <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

        <div class="lh-1" style="justify-items: center;">
            <h1 class="h6 mb-0 text-white lh-1"> Finalizados</h1>
        </div>
    </div>
    {{-- DataTable --}}
    <div class="container ">
        <div class="table-responsive">
            <table id="ticketsTableFinalized" class="table table-striped  table-sm  table-hover" style="text-align:center;">
                <thead class="table-success">
                    <tr>
                        {{-- <th class="dt-center">ID</th> --}}
                        <th class="dt-center">FOLIO</th>
                        <th class="dt-center">PRIORIDAD</th>
                        <th class="dt-center">FECHA</th>
                        <th class="dt-center">ESTATUS</th>

                        <th class="dt-center">DETALLE</th>
                        <th class="dt-center">ACTUALIZAR</th>
                        <th class="dt-center">HISTORIAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticketsFinalizados as $ticket)
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

                            <td >

                                <a href="{{ route('actualizar.ticket.finalizado',[
                                        "ticket" =>  $ticket,
                                        "encrypted" =>  $encrypted
                                    ]) }}" class="btn btn-outline-custom-color">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </a>

                            </td>

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
    </div>

    {{-- Subtitulo PENDIENTES--}}
    <div class="d-flex align-items-center p-3 my-3 text-white bg-subtitle-orange container rounded shadow-sm flex-centered " >
        <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

        <div class="lh-1" style="justify-items: center;">
            <h1 class="h6 mb-0 text-white lh-1"> Pendientes Pasados</h1>
        </div>
    </div>
    {{-- DataTable --}}
    <div class="container">
        <div class="table-responsive">
            <table id="ticketsTablePending" class="table table-striped  table-sm  table-hover" style="text-align:center;">
                <thead class="table-warning">
                    <tr>
                        {{-- <th class="dt-center">ID</th> --}}
                        <th class="dt-center">FOLIO</th>
                        <th class="dt-center">PRIORIDAD</th>
                        <th class="dt-center">FECHA</th>
                        <th class="dt-center">ESTATUS</th>

                        <th class="dt-center">DETALLE</th>
                        <th class="dt-center">COTIZAR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticketsPendientes as $ticket)
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

                            <td >

                                <a href="{{ route('cotizar.ticket.pendiente',[
                                    "ticket" =>  $ticket,
                                    "encrypted" =>  $encrypted
                                ]) }}" class="btn btn-outline-custom-color">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
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
    {{-- DATATABLE FINALIZADOS--}}
    <script>
        let tablaFinalizados = new DataTable('#ticketsTableFinalized',{
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

    {{-- DATATABLE PENDIENTES--}}
    <script>
        let tablaPendientes = new DataTable('#ticketsTablePending',{
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

            var source = `{!! asset('${strroute}termino/${ticket.EVIDENCIA_TERMINO}') !!}`;
            modal.find('.modal-body img#myimage_1').attr('src', source);

            var source = `{!! asset('${strroute}termino/${ticket.EVIDENCIA_TERMINO_2}') !!}`;
            modal.find('.modal-body img#myimage_2').attr('src', source);

            var source = `{!! asset('${strroute}termino/${ticket.EVIDENCIA_TERMINO_3}') !!}`;
            modal.find('.modal-body img#myimage_3').attr('src', source);

            modal.find('.modal-body textarea#descripcion_concreta').val(ticket.DETALLE)
        })
    </script>


@endsection
