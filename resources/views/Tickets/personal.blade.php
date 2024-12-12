@extends('layouts.tickets')

@section('title')
    Actualizar personal
@endsection


@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .flex-centered{
            display: flex;
            justify-content: center;
        }

        .centered{
            text-align: center;
        }

        .bg-title-create {
            background-color: #0dcaf0;
        }

        .bg-title-assign {
            background-color: #198754;
        }

        .bg-title-delete {
        background-color: #dc3546;
        }


        input[type=checkbox]{
            display: none;
        }

        i.user-delete{
            color: #0dcaf0;
        }

        input[type=checkbox]:checked + i.user-delete{
            color: #dc3546;
        }


    </style>
@endsection

@section('contenido')


    <main class="container">
        {{-- Subtitulo --}}
        <div class="d-flex align-items-center p-3 my-3 text-white bg-title-create rounded shadow-sm flex-centered" >
            <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

            <div class="lh-1" style="justify-items: : center;">
                <h1 class="h6 mb-0 text-white lh-1"> Crear Personal</h1>
            </div>
        </div>

        {{-- FORMULARIO DE CREACION --}}
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form id="encargados_crear" action=" {{ route('crear.personal') }}" method="POST" >
                @csrf

                <table class="table">
                    <thead>
                        <tr>
                            <th scope='col'class="centered">NOMBRE</th>
                            <th scope='col'class="centered">PUESTO</th>
                            <th scope='col'class="centered">AREA</th>
                            <th scope='col'class="centered">CORREO</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row">
                                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="40" required>
                            </th>

                            <th scope="row">
                                <select id="puesto" name="puesto" class="form-control" required>
                                    <option value="" >...</option>

                                    <option value="SUPERVISOR" >SUPERVISOR</option>
                                    <option value="SUBGERENTE" >SUBGERENTE</option>
                                    <option value="GERENTE" >GERENTE</option>
                                </select>
                            </th>

                            <th scope="row">
                                <select id="areas" name="areas" class="form-control" required>
                                    <option value="" >...</option>

                                    @foreach ($areas as $area)
                                        <option  value="{{ $area->ID_AREA }}"> {{ $area->NOMBRE }}</option>
                                    @endforeach
                                </select>
                            </th>


                            <th scope="row">
                                <input type="email" class="form-control" id="correo" name="correo" maxlength="40" pattern="[a-z0-9._%+-].+@[a-z0-9].com" required>
                            </th>

                        </tr>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-outline-info" style="margin-left: 95%"><i class="fa-solid fa-floppy-disk"></i></button>
            </form>

        </div>

        {{-- Subtitulo --}}
        <div class="d-flex align-items-center p-3 my-3 text-white bg-title-assign rounded shadow-sm flex-centered" >
            <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

            <div class="lh-1" style="justify-items: : center;">
                <h1 class="h6 mb-0 text-white lh-1"> Asignar Contacto General</h1>
            </div>
        </div>

        {{-- FORMULARIO DE ASINGACION CONTACTO GENERAL--}}
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form id="encargados_asignar" action=" {{ route('asignar.correo.casa') }}" method="POST" >
                @csrf
                @method('PATCH')

                <table class="table">
                    <thead>
                        <tr>
                            <th scope='col'class="centered">CASA</th>
                            <th scope='col'class="centered">CORREO</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row">
                                <select id="casas" name="casas" class="form-control" onchange="cargarDetallesCasaAssing(this)" required>
                                    <option value="" >...</option>

                                    @foreach ($casas as $casa)
                                        <option  value="{{ $casa->ID_CASA }}"> {{ $casa->NOMBRE }}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th scope="row">
                                <input type="email" class="form-control" id="correo_assign" name="correo_assign" maxlength="40" pattern="[a-z0-9._%+-].+@[a-z0-9].com" required>
                            </th>

                        </tr>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-outline-success" style="margin-left: 95%"><i class="fa-solid fa-floppy-disk"></i></button>


            </form>

        </div>


        {{-- Subtitulo --}}
        <div class="d-flex align-items-center p-3 my-3 text-white bg-title-assign rounded shadow-sm flex-centered" >
            <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

            <div class="lh-1" style="justify-items: : center;">
                <h1 class="h6 mb-0 text-white lh-1"> Asignar Personal</h1>
            </div>
        </div>

        {{-- FORMULARIO DE ASINGACION --}}
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form id="encargados_asignar" action=" {{ route('asignar.personal') }}" method="POST" >
                @csrf

                <table class="table">
                    <thead>
                        <tr>
                            <th scope='col'class="centered">NOMBRE</th>
                            <th scope='col'class="centered">PUESTO</th>
                            <th scope='col'class="centered">AREA</th>
                            <th scope='col'class="centered">CASA</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row">
                                <select id="encargados" name="encargados" class="form-control" onchange="cargarDetallesEncargadoAssing(this)" required>
                                    <option value="" >...</option>

                                    @foreach ($encargados as $encargado)
                                        <option  value="{{ $encargado->ID_ENCARGADO }}"> {{ $encargado->NOMBRE }}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th scope="row">
                                <input type="text" class="form-control" id="puesto_assign" name="puesto_assign" readonly>

                            </th>

                            <th scope="row">
                                <input type="text" class="form-control" id="area_assign" name="area_assign" readonly>
                            </th>

                            <th scope="row">
                                <select id="casas" name="casas" class="form-control" required>
                                    <option value="" >...</option>

                                    @foreach ($casas as $casa)
                                        <option  value="{{ $casa->ID_CASA }}"> {{ $casa->NOMBRE }}</option>
                                    @endforeach
                                </select>
                            </th>

                        </tr>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-outline-success" style="margin-left: 95%"><i class="fa-solid fa-floppy-disk"></i></button>


            </form>

        </div>




        {{-- Subtitulo --}}
        <div class="d-flex align-items-center p-3 my-3 text-white bg-title-delete rounded shadow-sm flex-centered" >
            <i class="fa-solid fa-users" style="margin-right: 20px;"z></i></i>

            <div class="lh-1" style="justify-items: : center;">
                <h1 class="h6 mb-0 text-white lh-1"> Eliminar Personal</h1>
            </div>
        </div>

        {{-- FORMULARIO DE ELIMINACION PERSONAL --}}
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form id="encargados_eliminar" action=" {{ route('eliminar.personal') }}" method="POST" >
                @csrf

                <table class="table">
                    <thead>
                        <tr>
                            <th scope='col'class="centered">NOMBRE</th>
                            <th scope='col'class="centered">PUESTO</th>
                            <th scope='col'class="centered">AREA</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row">
                                <select id="encargados_delete" name="encargados_delete" class="form-control" onchange="cargarDetallesEncargadoDelete(this)" required>
                                    <option value="" >...</option>

                                    @foreach ($encargados as $encargado)
                                        <option value="{{ $encargado->ID_ENCARGADO }}"> {{ $encargado->NOMBRE }}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th scope="row">
                                <input type="text" class="form-control" id="puesto_delete" name="puesto_delete" readonly>

                            </th>

                            <th scope="row">
                                <input type="text" class="form-control" id="area_delete" name="area_delete" readonly>
                            </th>

                        </tr>

                    </tbody>
                </table>

                <button type="submit" class="btn btn-outline-danger" style="margin-left: 95%"><i class="fa-solid fa-trash-can"></i></button>


            </form>

        </div>

        {{-- Subtitulo --}}
        <div class="d-flex align-items-center p-3 my-3 text-white bg-title-delete rounded shadow-sm flex-centered" >
            <i class="fa-solid fa-users" style="margin-right: 20px;"></i></i>

            <div class="lh-1" style="justify-items: : center;">
                <h1 class="h6 mb-0 text-white lh-1"> Eliminar Asignación Personal</h1>
            </div>
        </div>

        {{-- FORMULARIO DE ELIMINACION RELACIONES--}}
        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form id="relaciones_encargados_eliminar" action=" {{ route('eliminar.relacion.personal') }}" method="POST">
                @csrf

                <table id="relacionesTable" class="table table-striped table-bordered table-sm  table-hover checkbox-group required" >
                    <thead>
                        <tr>
                            <th scope='col'class="centered">#</th>
                            <th scope='col'class="centered">NOMBRE</th>
                            <th scope='col'class="centered">PUESTO</th>
                            <th scope='col'class="centered">AREA</th>
                            <th scope='col'class="centered">CASA</th>
                            <th scope='col'class="centered">ELIMINAR</th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($encargados_casas as $relacion)
                            <tr>
                                <th scope="row">{{ $relacion->ID_ENCARGADOS_CASAS }}</th>
                                <th scope="row">{{ $relacion->encargado->NOMBRE }}</th>
                                <th scope="row">{{ $relacion->encargado->PUESTO }}</th>
                                <th scope="row">{{ $relacion->encargado_area->NOMBRE }}</th>
                                <th scope="row">{{ $relacion->casa->NOMBRE }}</th>

                                <th scope="row" class="flex-centered" >
                                    <label  style="text-align:center;">
                                        <input type="checkbox" name="encargado_casa[{{ $relacion->ID_ENCARGADOS_CASAS }}]"  form="relaciones_encargados_eliminar" value="{{ $relacion->ID_ENCARGADOS_CASAS }}" onclick="revisarCheck()"/>
                                        <i class="fa-solid fa-user-slash user-delete"></i>
                                    </label>
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <button type="submit" id="btn_eliminar_relacion" class="btn btn-outline-danger" style="margin-left: 95%" disabled><i class="fa-solid fa-trash-can"></i></button>

            </form>

        </div>

    </main>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
    //RUTAS
        //let strroute = '/Aportaciones/tickets/creacion/'
        let strroute = '/tickets/creacion/'

    // RECURSOS DE LIMPIEZA DE SELECTS
        function limpiarElemento(element){
            element.value = "";
        }

        function limpiarSelect(select){
            while (select.options.length > 1){
                select.remove(1);
            }
        }
    // ENCARGADOS ASIGN
        function cargarDetallesEncargadoAssing(encargadoSelect) {
            let id = encargadoSelect.value;
            // let area = encargadoSelect.options[encargadoSelect.selectedIndex].dataset.area;

            // Cargar colecciones de las dependencias de los encargados
            fetch(`${strroute}${id}/Encargados`)
                .then(response => response.json())
                .then(jsonData => crearDetallesAssign(jsonData))

        }

        function crearDetallesAssign(jsonDetalles){
            let puestoInput = document.getElementById('puesto_assign');
            let areaInput = document.getElementById('area_assign');

            limpiarElemento(puestoInput);
            limpiarElemento(areaInput);

            puestoInput.value   = jsonDetalles['encargado'].PUESTO;
            areaInput.value     = jsonDetalles['area'];

        }

        function cargarDetallesCasaAssing(casaSelect) {
            let id = casaSelect.value;

            // Cargar colecciones de las dependencias de los encargados
            fetch(`${strroute}${id}/Casas`)
                .then(response => response.json())
                .then(jsonData => crearCorreoAssign(jsonData))

        }

        function crearCorreoAssign(jsonDetalles){
            let correoInput = document.getElementById('correo_assign');

            limpiarElemento(correoInput);

            correoInput.value   = jsonDetalles.CORREO;
        }

    // ENCARGADOS DELETE
        function cargarDetallesEncargadoDelete(encargadoSelect) {
            let id = encargadoSelect.value;

            // Cargar colecciones de las dependencias de los encargados
            fetch(`${strroute}${id}/Encargados`)
                .then(response => response.json())
                .then(jsonData => crearDetallesDelete(jsonData))

        }

        function crearDetallesDelete(jsonDetalles){
            let puestoInput = document.getElementById('puesto_delete');
            let areaInput = document.getElementById('area_delete');

            limpiarElemento(puestoInput);
            limpiarElemento(areaInput);

            puestoInput.value   = jsonDetalles['encargado'].PUESTO;
            areaInput.value     = jsonDetalles['area'];
        }


    </script>

    <script>
    //DATATABLE
        let tabla = new DataTable('#relacionesTable',{
            lengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, 'All']
            ],
            order: [[0, 'asc']],
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

    <script>
        function revisarCheck() {
            let boton = document.getElementById('btn_eliminar_relacion');

            if ($('table.checkbox-group.required :checkbox:checked').length > 0) {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }

        }
    </script>
@endsection
