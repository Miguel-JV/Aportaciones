{{-- vista extendida del layout --}}
@extends('layouts.tickets')

@section('title')
    Crear Ticket
@endsection

@section('css')

@endsection


@section('contenido')
    <div class="container form-container ">
        <div class="form-header">
            <h2>Reporte de Daño</h2>
        </div>

        <form action="{{ route('create.ticket') }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="ticket">Ticket</label>
                    <input type="text" class="form-control" id="ticket" name="ticket" data-folio= "{{ $folio }}" value="{{ $folio }}"  readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="fecha">Fecha</label>
                    <input type="text" class="form-control" id="fecha" name="fecha" value="{{ date("Y-m-d") }}" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="estatus">Estatus</label>
                    <input type="text" class="form-control" id="estatus" name="estatus" value="PENDIENTE" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="areas">Área Responsable</label>
                    <input type="text" class="form-control" id="areas" name="areas" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="director">Director(a)</label>
                    <input type="text" class="form-control" id="director" name="director" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="supervisor">Supervisor</label>
                    <input type="text" class="form-control" id="supervisor" name="supervisor" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="subgerente">Subgerente</label>
                    <input type="text" class="form-control" id="subgerente" name="subgerente" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="gerente">Gerente</label>
                    <input type="text" class="form-control" id="gerente" name="gerente" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="casa">Casa</label>

                        @if (Auth::user()->rol == 'coordinador')
                            <select id="casa" onchange="cargarDependenciasCasas(this)" name="casa" class="form-control" required>
                                <option value="">Seleccione una casa...</option>

                                @foreach ($casas as $casa)
                                    <option data-nombre="{{ substr($casa->NOMBRE,0,2) }}" value="{{ $casa->ID_CASA }}">
                                        {{ $casa->NOMBRE }}
                                    </option>
                                @endforeach

                            </select>
                        @elseif (Auth::user()->rol == 'director')
                            <input type="hidden" name="casa" value="{{ $casaDirector->ID_CASA }}"/>
                            <select id="casa" onchange="cargarDependenciasCasas(this)" name="casa" class="form-control" required disabled="true">
                                <option data-nombre="{{ substr($casaDirector->NOMBRE,0,2) }}" value="{{ $casaDirector->ID_CASA }}" selected>
                                    {{ $casaDirector->NOMBRE }}
                                </option>
                            </select>

                        @endif
                </div>

                <div class="form-group col-md-4">
                    <label for="afeccion">Afecta</label>
                    <select id="afeccion" onchange="cargarDependenciasAfecciones(this)" name="afeccion" class="form-control" required>
                        <option value="">Seleccione una afeccion...</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="reincidencia">Garantía</label>
                    <select id="reincidencia" name="reincidencia" class="form-control" required>
                        <option value="">Selecciona la reincidencia...</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="entorno">Entorno</label>
                    <select id="entorno" onchange="cargarDependenciasEntornos(this)" name="entorno" class="form-control" required>
                        <option value="">Selecciona un entorno...</option>

                        @foreach ($entornos as $entorno)
                            <option value="{{ $entorno->ID_ENTORNO }}">{{ $entorno->ENTORNO }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="sitio">Sitio</label>
                    <select id="sitio" onchange="cargarDependenciasSitios(this)" name="sitio" class="form-control" required>
                        <option value="">Selecciona un sitio...</option>

                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="espacio">Espacio</label>
                    <select id="espacio" name="espacio" class="form-control">
                        <option value="">Selecciona un espacio...</option>

                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="objeto">Objeto</label>
                    <select id="objeto" onchange="cargarDependenciasObjeto(this)" name="objeto" class="form-control">
                        <option value="">Selecciona un objeto...</option>

                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="elemento">Elemento</label>
                    <select id="elemento" name="elemento" class="form-control">
                        <option value="">Selecciona un elemento...</option>

                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="daño">Daño</label>
                    <select id="daño" onchange="cargarDependenciasDaño(this)" name="daño" class="form-control" required>
                        <option value="">Selecciona un Daño...</option>

                        @foreach ($tipos_danos as $tipo_daño)
                            <option value="{{ $tipo_daño->ID_TIPO_DANO }}">{{ $tipo_daño->DETALLE }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="prioridad">Prioridad</label>
                    <input type="text" class="form-control" id="prioridad" name="prioridad" readonly>
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
                <div class="form-group col-md-6">
                    <label for="link_fotos">Link Carpeta de Fotos</label>
                    <textarea id="link_fotos" name="link_fotos" class="form-control" rows="2" readonly></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion_concreta">Descripción Concreta</label>
                    <textarea id="descripcion_concreta" name="descripcion_concreta" class="form-control" rows="2" maxlength="100" placeholder="Max 100 caracteres" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary btn-custom" onclick="cambiarBG();">Guardar</button>
                </div>
                <div class="form-group col-md-6">
                    <button type="reset" class="btn btn-secondary btn-custom">Limpiar</button>
                </div>
            </div>
        </form>
    </div>


@endsection


@section('js')
<script>
    function cargar() {
        let casa = document.getElementById('casa');
        cargarDependenciasCasas(casa);
    }

    window.onload = cargar;
</script>

<script>
//RUTAS
    //let strroute = '/Aportaciones/tickets/creacion/'
    let strroute = '/tickets/creacion/'
// MODIFICACION DE ELEMENTOS INPUT FILE
    let labelArchivo = '';

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

// RECURSOS DE LIMPIEZA DE SELECTS
    function limpiarElemento(element){
        element.value = "";
    }

    function limpiarSelect(select){
        while (select.options.length > 1){
            select.remove(1);
        }
    }

// CASAS
    function cargarDependenciasCasas(casaSelect) {
        let casaId = casaSelect.value;

        // Completar nombre del ticket con la casa
        let ticket = document.getElementById('ticket');
        let casa = casaSelect.options[casaSelect.selectedIndex].dataset.nombre;
        ticket.value = ticket.dataset.folio  + casa;

        let sitiosSelect        = document.getElementById('sitio')
        let espaciosSelect      = document.getElementById('espacio')
        let objetosSelect       = document.getElementById('objeto')
        let elementosSelect     = document.getElementById('elemento')

        limpiarSelect(sitiosSelect);
        limpiarSelect(espaciosSelect);
        limpiarSelect(objetosSelect);
        limpiarSelect(elementosSelect);

        // Cargar colecciones de las dependencias de las casas
        fetch(`${strroute}${casaId}/Directores`)
            .then(response => response.json())
            .then(jsonData => crearDirector(jsonData))

        fetch(`${strroute}${casaId}/Drives`)
            .then(response => response.json())
            .then(jsonData => crearDrive(jsonData))

        fetch(`${strroute}${casaId}/Afecciones`)
            .then(response => response.json())
            .then(jsonData => crearAfecciones(jsonData))


    }

    function crearDirector(jsonDirectores){
        let directoresInput = document.getElementById('director');
        limpiarElemento(directoresInput);

        jsonDirectores.forEach(director => {
            directoresInput.value = director.NOMBRE
        });
    }

    function crearDrive(jsonDrive){
        let driveTextArea = document.getElementById('link_fotos');
        limpiarElemento(driveTextArea);

        jsonDrive.forEach(drive => {
            driveTextArea.value = drive.LIGA
        });
    }



// AFECCIONES
    function crearAfecciones(jsonAfecciones){
        // En funcion de la casa
        let afeccionesSelect = document.getElementById('afeccion');
        limpiarSelect(afeccionesSelect);

        jsonAfecciones.forEach(afeccion => {
            let option = document.createElement('option');
            option.value = afeccion.ID_AFECCION;
            option.innerHTML = afeccion.NOMBRE;
            afeccionesSelect.append(option);
        });
    }

    function cargarDependenciasAfecciones(afeccionSelect) {
        let casaSelect = document.getElementById('casa');
        let afeccionId = afeccionSelect.value;
        let casaId = casaSelect.value;

        fetch(`${strroute}${afeccionId}/Areas`)
            .then(response => response.json())
            .then(jsonData => crearArea(jsonData))


        fetch(`${strroute}${casaId}/${afeccionId}/Supervisores`)
            .then(response => response.json())
            .then(jsonData => crearSupervisor(jsonData))

        fetch(`${strroute}${casaId}/${afeccionId}/Subgerentes`)
            .then(response => response.json())
            .then(jsonData => crearSubgerente(jsonData))

        fetch(`${strroute}${casaId}/${afeccionId}/Gerentes`)
            .then(response => response.json())
            .then(jsonData => crearGerente(jsonData))
    }

    function crearArea(jsonArea){
        let areasInput = document.getElementById('areas');

        let afeccionInput = document.getElementById('afeccion');
        let casaSelect = document.getElementById('casa');

        // POR CONVENIO SEDENA Y SEMAR SE ENCARGAN DE LAS AFECCIONES
        //  MENOS ALARMA                ,   PUBLICIDAD               Y            SISTEMA DE AIRE
        if ((afeccionInput.value == 1) || (afeccionInput.value == 2) || (afeccionInput.value == 13)) {
            limpiarElemento(areasInput);
            jsonArea.forEach(area => {
                areasInput.value = area.NOMBRE;
            });

        // SEDENA
        }else if (casaSelect.value == 9) {
            limpiarElemento(areasInput);
            areasInput.value = 'SEDENA';
        // SEMAR
        }else if(casaSelect.value == 10){
            limpiarElemento(areasInput);
            areasInput.value = 'SEMAR'
        }

        else{
            limpiarElemento(areasInput);
            jsonArea.forEach(area => {
                areasInput.value = area.NOMBRE;
            });
        }

    }

    function crearSupervisor(jsonSupervisor){
        let supervisoresInput = document.getElementById('supervisor');
        let afeccionInput = document.getElementById('afeccion');
        let casaSelect = document.getElementById('casa');


        switch(true) {
            // POR CONVENIO SEDENA Y SEMAR SE ENCARGAN DE LAS AFECCIONES
            //SEDENA SEMAR
            case (casaSelect.value == 9 || casaSelect.value == 10):
                //  MENOS ALARMA                ,   PUBLICIDAD               Y            SISTEMA DE AIRE
                if ((afeccionInput.value == 1) || (afeccionInput.value == 2) || (afeccionInput.value == 13)) {
                    limpiarElemento(supervisoresInput);
                    supervisoresInput.value = jsonSupervisor.NOMBRE;
                }else{
                    limpiarElemento(supervisoresInput);
                }
                break;
            default:
                limpiarElemento(supervisoresInput);
                supervisoresInput.value = jsonSupervisor.NOMBRE;
        }

    }

    function crearSubgerente(jsonSubgerente){
        let subgerentesInput = document.getElementById('subgerente');
        let afeccionInput = document.getElementById('afeccion');
        let casaSelect = document.getElementById('casa');

        switch(true) {
            // POR CONVENIO SEDENA Y SEMAR SE ENCARGAN DE LAS AFECCIONES
            //SEDENA SEMAR
            case (casaSelect.value == 9 || casaSelect.value == 10):
                //  MENOS ALARMA                ,   PUBLICIDAD               Y            SISTEMA DE AIRE
                if ((afeccionInput.value == 1) || (afeccionInput.value == 2) || (afeccionInput.value == 13)) {
                    limpiarElemento(subgerentesInput);
                    subgerentesInput.value = jsonSubgerente.NOMBRE;
                }else{
                    limpiarElemento(subgerentesInput);
                }
                break;
            default:
                limpiarElemento(subgerentesInput);
                subgerentesInput.value = jsonSubgerente.NOMBRE;
        }

    }

    function crearGerente(jsonGerente){
        let gerentesInput = document.getElementById('gerente');
        let afeccionInput = document.getElementById('afeccion');
        let casaSelect = document.getElementById('casa');

        switch(true) {
            // POR CONVENIO SEDENA Y SEMAR SE ENCARGAN DE LAS AFECCIONES
            //SEDENA SEMAR
            case (casaSelect.value == 9 || casaSelect.value == 10):
                //  MENOS ALARMA                ,   PUBLICIDAD               Y            SISTEMA DE AIRE
                if ((afeccionInput.value == 1) || (afeccionInput.value == 2) || (afeccionInput.value == 13)) {
                    limpiarElemento(gerentesInput);
                    gerentesInput.value = jsonGerente.NOMBRE;
                }else{
                    limpiarElemento(gerentesInput);
                }
                break;
            default:
                limpiarElemento(gerentesInput);
                gerentesInput.value = jsonGerente.NOMBRE;
        }
    }


// ENTORNOS
    function cargarDependenciasEntornos(entornosSelect) {
            let entornosId = entornosSelect.value;
            let casaSelect = document.getElementById('casa');
            let casaId =     casaSelect.value;

            let elementoSelect = document.getElementById('elemento')
            limpiarSelect(elementoSelect);


            fetch(`${strroute}${entornosId}/${casaId}/Sitios`)
                .then(response => response.json())
                .then(jsonData => crearSitios(jsonData))

            fetch(`${strroute}${entornosId}/Objetos`)
                .then(response => response.json())
                .then(jsonData => crearObjetos(jsonData))

    }

    function crearSitios(jsonSitios){
        let sitiosSelect = document.getElementById('sitio')
        let espacioSelect = document.getElementById('espacio')
        limpiarSelect(sitiosSelect);
        limpiarSelect(espacioSelect);

        jsonSitios.forEach(sitio => {
            let option = document.createElement('option');
            option.value = sitio.ID_SITIO;
            option.innerHTML = sitio.SITIO;
            sitiosSelect.append(option);
        });
    }
// SITIOS
    function cargarDependenciasSitios(sitiosSelect) {
            let sitiosId = sitiosSelect.value;

            fetch(`${strroute}${sitiosId}/Espacio`)
                .then(response => response.json())
                .then(jsonData => crearEspacio(jsonData))

    }

    function crearEspacio(jsonEspacio){
        let espacioSelect = document.getElementById('espacio')

        limpiarSelect(espacioSelect);

        jsonEspacio.forEach(espacio => {
            let option = document.createElement('option');
            option.value = espacio.ID_ESPACIO;
            option.innerHTML = espacio.NOMBRE;
            espacioSelect.append(option);
        });

    }

    function crearObjetos(jsonObjetos){
        let objetoSelect = document.getElementById('objeto')
        let elementoSelect = document.getElementById('elemento')
        limpiarSelect(objetoSelect);
        limpiarSelect(elementoSelect);

        jsonObjetos.forEach(objeto => {
            let option = document.createElement('option');
            option.value = objeto.ID_OBJETO;
            option.innerHTML = objeto.NOMBRE;
            objetoSelect.append(option);
        });
    }
// ELEMENTOS
    function cargarDependenciasObjeto(objetoSelect) {
        let objetoId = objetoSelect.value;

        fetch(`${strroute}${objetoId}/Elementos`)
            .then(response => response.json())
            .then(jsonData => crearElemento(jsonData))

    }

    function crearElemento(jsonElementos) {
        let elementoSelect = document.getElementById('elemento')

        limpiarSelect(elementoSelect);

        jsonElementos.forEach(elemento => {
            let option = document.createElement('option');
            option.value = elemento.ID_ELEMENTO_OBJ;
            option.innerHTML = elemento.NOMBRE;
            elementoSelect.append(option);
        });
    }

// DAÑOS
    function cargarDependenciasDaño(dañoSelect) {
        let dañoId = dañoSelect.value;

        fetch(`${strroute}${dañoId}/Prioridades`)
            .then(response => response.json())
            .then(jsonData => crearPrioridad(jsonData))
    }

    function crearPrioridad(jsonPrioridades){
        let prioridadesInput = document.getElementById('prioridad');
        limpiarElemento(prioridadesInput);

        jsonPrioridades.forEach(prioridad =>{
            prioridadesInput.value = prioridad.NOMBRE;
        });
    }



</script>

@endsection
