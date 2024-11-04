<?php

namespace App\Http\Controllers;

// Controlador de Modelos
use App\casas;
use App\directores;
use App\drives;
use App\tipos_danos;
use App\prioridades;
use App\afecciones;
use App\areas;
use App\entornos;
use App\sitios;
use App\espacios;
use App\objetos;
use App\elementos_objetos;
use App\tickets;

use App\encargados;
use App\encargados_casas;

use App\modificaciones;


// Controlador de correos
use Illuminate\Support\Facades\Mail;
use App\Mail\ReporteQuincenalCompleto;
use App\Mail\ReporteQuincenalCT;
use App\Mail\ReporteQuincenalResumen;

use App\Mail\GeneracionTicket;
use App\Mail\ObservacionesTicket;
use App\Mail\CotizacionTicket;
use App\Mail\AutorizacionTicket;
use App\Mail\NotificacionTicketDirecto;


// Obtención de campos
use Illuminate\Http\Request;

// Dependencias de Excel
use App\Exports\consultaCompuestaTickets;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ticketResumenGeneral;
use App\Exports\ticketEstatusDetalle;
use App\Exports\ticketsExport;


// Namespace para fechas
use Carbon\Carbon;

// Namespace para encriptacióon de cadenas
use Illuminate\Support\Facades\Crypt;

class TicketsController extends Controller
{
// CONTROL DE REGISTROS POR TRIMESTRE (KERNEL AUTOMATIZADO)
    // public function eliminarFotoTicket($nombre_foto){
    //     // $nombre_foto = '1728068080_1.jpg';
    //     \Storage::disk('tickets')->delete($nombre_foto);
    // }

// CONSULTAS FETCH JS
    public function obtenerDirectores($id){
        $casa = casas::find($id);
        return directores::where('ID_CASA', $casa->ID_CASA)->get();
    }

    public function obtenerDrives($id){
        $casa = casas::find($id);
        return drives::where('ID_CASA', $casa->ID_CASA)->get();
    }

    public function obtenerAfecciones($id){
        $casa = casas::find($id);
        $ignorarAfecciones = [];
        // IGNORAR AFECCIONES QUE NO LE CORRESPONDEN ALDEA
        if ($casa->ID_CASA == 1){
            // IGNORAR ->DETERIORO, INFRAESTRUCTURA , SEGURIDAD -> (INDIVIDUAL)
            $ignorarAfecciones = [3,6,11];
        }else{
            // IGNORAR ->DETERIORIOROS, INFRAESTRUCTURAS, SEGURIDAD ALDEA ->POR ENTORNO(INTERNOS EXTERNOS)
            $ignorarAfecciones = [4,5, 7,8, 12];
        }
        return afecciones::whereNotIn('ID_AFECCION',$ignorarAfecciones)->get();
    }

    public function obtenerAreas($id){
        $afecciones = afecciones::find($id);
        return areas::where('ID_AREA', $afecciones->ID_AREA)->get();
    }

    public function obtenerSitios($id_entornos, $id_casa){
        $entornos = entornos::find($id_entornos);
        $casa = casas::find($id_casa);

        // Sitios exclusivos de casas
        $ignorarSitios = [];
        $exclusivos_aldea = [1,2,14,15,17,46];
        $exclusivos_tuxtla = [27,28,29,33,36,48];
        $exclusivos = array_merge($exclusivos_aldea, $exclusivos_tuxtla);

        switch ($casa->ID_CASA) {
            // ALDEA
            case 1:
                $ignorarSitios = $exclusivos_tuxtla;
                break;

            // TUXTLA
            case 7:
                $ignorarSitios = $exclusivos_aldea;
                break;

            default:
                $ignorarSitios = $exclusivos;
                break;
        }

        return sitios::where('ID_ENTORNO', $entornos->ID_ENTORNO)->whereNotIn('ID_SITIO', $ignorarSitios)->get();
    }

    public function obtenerEspacio($id){
        $sitios = sitios::find($id);

        return espacios::where('ID_SITIO', $sitios->ID_SITIO)->get();
    }
    public function obtenerObjetos($id){
        $entornos = entornos::find($id);
        return objetos::where('ID_ENTORNO', $entornos->ID_ENTORNO)->get();
    }

    public function obtenerElementos($id){
        $objeto = objetos::find($id);
        return elementos_objetos::where('ID_OBJETO', $objeto->ID_OBJETO)->get();
    }

    public function obtenerPrioridades($id){
        $daño = tipos_danos::find($id);
        return prioridades::where('ID_PRIORIDAD', $daño->ID_PRIORIDAD)->get();
    }
    // tabla intermedia
    public function obtenerEncargados($id){
        $encargado = encargados::find($id);
        $area = areas::find($encargado->ID_AREA);


        $data = [
            'encargado' => $encargado,
            'area' => $area->NOMBRE,
        ];

            return json_encode($data);
        // }
    }

    public function obtenerSupervisores($id_casa, $id_afeccion){
        $casa = casas::find($id_casa);
        $afeccion = afecciones::find($id_afeccion);

        // Obtener el encargado por tabla intermedia
        $encargado = $casa->supervisor_casa->where('ID_AREA', $afeccion->ID_AREA)->first();

        if (is_null($encargado)){
            return json_encode(['NOMBRE'=>'NO REGISTRADO']);
        }
        else{
            //  $encargado;
            return json_encode($encargado);
        }
    }

    public function obtenerSubgerentes($id_casa, $id_afeccion){
        $casa = casas::find($id_casa);
        $afeccion = afecciones::find($id_afeccion);

        // Obtener el encargado por tabla intermedia
        $encargado = $casa->subgerente_casa->where('ID_AREA', $afeccion->ID_AREA)->first();

        if (is_null($encargado)){
            return json_encode(['NOMBRE'=>'NO REGISTRADO']);
        }
        else{
            //  $encargado;
            return json_encode($encargado);
        }
    }

    public function obtenerGerentes($id_casa, $id_afeccion){
        $casa = casas::find($id_casa);
        $afeccion = afecciones::find($id_afeccion);

        // Obtener el encargado por tabla intermedia
        $encargado = $casa->gerente_casa->where('ID_AREA', $afeccion->ID_AREA)->first();

        if (is_null($encargado)){
            return json_encode(['NOMBRE'=>'NO REGISTRADO']);
        }
        else{
            //  $encargado;
            return json_encode($encargado);
        }
    }

// VISTAS
    public function crearTickets(){

        $casas = casas::all();
        $directores = directores::all();
        $drives = drives::all();
        $tipos_danos = tipos_danos::all();
        $afecciones = afecciones::all();
        $areas = areas::all();
        $entornos = entornos::all();
        $sitios = sitios::all();
        $espacios = espacios::all();
        $objetos = objetos::all();
        $elementos_objetos = elementos_objetos::all();

        // Formato de folio RM-AÑO/ID_NUEVO-CASA(ABREVIADO)
        $folio  = '[RM-' .  date("Y") . ']-';

        $id_ticket = tickets::select('ID_TICKET')->orderBy('ID_TICKET', 'desc')->first();

        // Folio 1 cuando esté vacío
        if (is_null($id_ticket)){ $folio .= '1';}
        else{ $folio .= $id_ticket->ID_TICKET + 1;}

        $folio .= '-';

        return view('Tickets.crearticket',
        compact(
            'casas', 'directores', 'drives',
            'tipos_danos', 'afecciones', 'areas',
            'entornos','sitios', 'espacios',
            'objetos', 'elementos_objetos', 'folio'
        ));
    }

    public function consultarTickets(){
        $currentYear = date('Y');
        $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->orderBy('FECHA_INICIO', 'DESC')->get();

        return view('Tickets.consultarticket', compact('tickets'));

    }

    public function generaReporteTickets(){

        $now = Carbon::now()->format("Y-m-d");
        $startWeek = Carbon::now()->startOfWeek()->format("Y-m-d");

        return view('Tickets.generarreporte', compact('now', 'startWeek'));

        // $dateStart = Carbon::now()->startOfMonth();
        // $dateEnd = Carbon::now();

        // $tickets = tickets::whereBetween('FECHA_INICIO', [$dateStart,$dateEnd])->where('CASA', 'Aldea Iztapalapa')->get();
        // $aldea = $tickets->sum('COTIZACION');


        // echo $aldea;

    }

    public function actualizarTickets(tickets $ticket){
        $areas = areas::all();

        return view('Tickets.actualizarticket', compact('ticket', 'areas'));
    }

    public function historialTickets(tickets $ticket){
        $modificaciones = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->orderBy('FECHA', 'DESC')->get();
        return view('Tickets.historialticket', compact('modificaciones'));

    }



    public function validarTickets(tickets $ticket){
        $prioridades = prioridades::all();

        if ($ticket->modificaciones->where('TIPO', 'VALIDACION')->isEmpty()) {
            $validado = false;
            return view('Tickets.validarticket', compact('ticket', 'prioridades', 'validado'));
        } else {
            $validado = true;
            $ultimaValidacion = $ticket->modificaciones->where('TIPO', 'VALIDACION')->first();
            return view('Tickets.validarticket', compact('ticket', 'prioridades', 'validado', 'ultimaValidacion'));

        }

    }

    public function cotizarTickets(tickets $ticket, $encargado){
        // // $encrypted = Crypt::encryptString('Hello world.');
        $ultimaCotizacion = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','COTIZACION')->orderBy('FECHA','DESC')->first();
        $ultimaFechaCompromiso = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','FECHA COMPROMISO')->orderBy('FECHA','DESC')->first();
        $decrypted = Crypt::decryptString($encargado);

        // echo $decrypted;
        return view('Tickets.cotizarticket', compact('ticket', 'encargado', 'decrypted', 'ultimaCotizacion', 'ultimaFechaCompromiso'));
    }

    public function modificarCotizacion(tickets $ticket, $encargado) {
        $decrypted = Crypt::decryptString($encargado);

        return view('Tickets.modifiicarcotizacionticket', compact('ticket', 'decrypted'));
    }

    public function autorizarTicket(tickets $ticket, $encargado){

        $ultimaCotizacion = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','COTIZACION')->orderBy('FECHA','DESC')->first();
        $decrypted = Crypt::decryptString($encargado);

        return view('Tickets.autorizarticket', compact('ticket', 'encargado', 'decrypted', 'ultimaCotizacion'));
    }

    public function modificarPersonal(){
        $casas = casas::all();
        $areas = areas::all();
        $encargados = encargados::all();
        $encargados_casas = encargados_casas::all();

        $tickets = tickets::all();


        return view('Tickets.personal', compact('casas', 'areas', 'encargados', 'encargados_casas', 'tickets'));

    }
// ACCION FORMULARIOS

    public function crear(Request $request){

        // Data Campos
        $id_casa =          $request->input('casa');
        $id_afeccion =      $request->input('afeccion');
        $id_entorno =       $request->input('entorno');
        $id_tipo_daño =     $request->input('daño');

        $folio =            $request->input('ticket');
        $f_inicio =         $request->input('fecha');
        $estatus_actual =   $request->input('estatus');

        // Obtener nombre de campos en función del VALUE/ID
        $casa =             casas::find($request->input('casa'))->NOMBRE;
        $director =         $request->input('director');
        $afeccion =         afecciones::find($request->input('afeccion'))->NOMBRE;
        // ver posible request del id del input en areas
        $area_responsable = $request->input('areas');
        $supervisor =       $request->input('supervisor');
        $subgerente =       $request->input('subgerente');
        $gerente =          $request->input('gerente');
        $prioridad =        $request->input('prioridad');
        $reincidencia =     $request->input('reincidencia');
        $entorno =          entornos::find($request->input('entorno'))->ENTORNO;
        $sitio =            sitios::find($request->input('sitio'))->SITIO;

        // Validar posibles espacios vacíos
        $objeto =           self::validarNulos($request->input('objeto'), objetos::all());
        $espacio =          self::validarNulos($request->input('espacio'), espacios::all());
        $elemento =         self::validarNulos($request->input('elemento'), elementos_objetos::all());

        $daño =             tipos_danos::find($request->input('daño'))->DETALLE;
        $drive =            $request->input('link_fotos');
        $detalle =          $request->input('descripcion_concreta');

        $estatus_casa =     casas::find($request->input('casa'))->ESTATUS;

        // Carga y guardado de Imagenes
        $foto_1 =             self::cargaImg($request->file('foto_obligatoria'));
        $foto_2 =             self::cargaImg($request->file('foto_opcional_2'));
        $foto_3 =             self::cargaImg($request->file('foto_opcional_3'));
        $arreglo_fotos =              [$foto_1, $foto_2, $foto_3];

        // Devolver arreglo sin fotos vacías
        $fotos = array_filter($arreglo_fotos, function($item){
            return !empty($item);
        });


        // Rellenar BD tickets_table
        $ticket = new tickets;

        $ticket->ID_CASA =          $id_casa;
        $ticket->ID_AFECCION =      $id_afeccion;
        $ticket->ID_ENTORNO =       $id_entorno;
        $ticket->ID_TIPO_DANO =     $id_tipo_daño;

        $ticket->FOLIO =            $folio;
        $ticket->FECHA_INICIO =     $f_inicio;

        $ticket->CASA =             $casa;
        $ticket->DIRECTOR =         $director;
        $ticket->AFECCION =         $afeccion;
        $ticket->AREA_RESPONSABLE = $area_responsable;
        $ticket->SUPERVISOR =       $supervisor;
        $ticket->SUBGERENTE =       $subgerente;
        $ticket->GERENTE =          $gerente;
        $ticket->PRIORIDAD =        $prioridad;
        $ticket->REINCIDENCIA =     $reincidencia;
        $ticket->ENTORNO =          $entorno;
        $ticket->SITIO =            $sitio;

        $ticket->OBJETO =           $objeto;
        $ticket->ESPACIO =          $espacio;
        $ticket->ELEMENTO =         $elemento;

        $ticket->DAÑO =             $daño;
        $ticket->FOTO_OBLIGATORIA = $foto_1;
        $ticket->FOTO_2 =           $foto_2;
        $ticket->FOTO_3 =           $foto_3;
        $ticket->DRIVE =            $drive;
        $ticket->DETALLE =          $detalle;

        $ticket->ESTATUS_CASA=      $estatus_casa;
        $ticket->ESTATUS_COTIZACION     ='NO';
        $ticket->ESTATUS_AUTORIZACION   ='NO';
        $ticket->ESTATUS_ACTUAL =   $estatus_actual;




        $area    = $ticket->afeccion->area_afeccion;

        // Contenido del correo
        $data = [
            'destinatario'  => null,

            'folio'         => $folio,
            'casa'          => $casa,
            'area'          => $area_responsable,

            'fecha_inicio'  => $f_inicio,
            'estatus'       => $estatus_actual,
            'afeccion'      => $afeccion,

            'reinicidencia' => $reincidencia,
            'entorno'       => $entorno,
            'sitio'         => $sitio,
            'espacio'       => $espacio,
            'objeto'        => $objeto,
            'elemento'      => $elemento,
            'daño'          => $daño,
            'prioridad'     => $prioridad,
            'detalle'       => $detalle,

            'fotos'         => $fotos,
            'drive'         => $drive,

            'director'      => $director,
            'ticket'        => $ticket,

            'validado'      => false,
        ];

        $ticket->save();

        // Enviar correo a Vo.Bo.
        switch (true) {
            case ($reincidencia == 'SI'):
                $destinatarios = [
                    'supervisores' => [
                        'Jorge Leybon' => 'reportes.bdt@gmail.com',
                        'Saul Delgadillo' => 'reportes.bdt@gmail.com',
                    ]
                ];

                if ($area_responsable == 'FYCSA') {
                    self::envioPrioritarioDirecto($area, $data);
                    $area = areas::where('NOMBRE', 'CTBR')->first();
                    self::envioPrioritarioDirecto($area, $data);

                    // Enviar correo a supervisores Jorge - Saul
                    self::envioDestinatariosDirecto($destinatarios, $data);

                } else {
                    self::envioPrioritarioDirecto($area, $data);

                    // Enviar correo a supervisores Jorge - Saul
                    self::envioDestinatariosDirecto($destinatarios, $data);
                }
                break;

            case ($daño == 'Siniestro'):
                $destinatarios = [
                    'supervisores' => [
                        'Jorge Leybon' => 'reportes.bdt@gmail.com',
                        'Saul Delgadillo' => 'reportes.bdt@gmail.com',
                    ]
                ];

                if ($area_responsable == 'FYCSA') {
                    self::envioPrioritarioDirecto($area, $data);
                    $area = areas::where('NOMBRE', 'CTBR')->first();
                    self::envioPrioritarioDirecto($area, $data);

                    // Enviar correo a supervisores Jorge - Saul
                    self::envioDestinatariosDirecto($destinatarios, $data);

                } else {
                    self::envioPrioritarioDirecto($area, $data);

                    // Enviar correo a supervisores Jorge - Saul
                    self::envioDestinatariosDirecto($destinatarios, $data);
                }
                break;

            case ($area_responsable == 'SEDENA'):
                $destinatarios = [
                    'supervisores' => [
                        'Jorge Leybon' => 'reportes.bdt@gmail.com',
                        'Saul Delgadillo' => 'reportes.bdt@gmail.com',
                        'Nayely Aguilar' => 'reportes.bdt@gmail.com',
                    ]
                ];
                self::envioPrioritarioDirecto($area, $data);

                // Enviar correo a supervisores Jorge - Saul -Naye
                self::envioDestinatariosDirecto($destinatarios, $data);
                break;

            case ($area_responsable == 'SEMAR'):
                $destinatarios = [
                    'supervisores' => [
                        'Jorge Leybon' => 'reportes.bdt@gmail.com',
                        'Saul Delgadillo' => 'reportes.bdt@gmail.com',
                        'Nayely Aguilar' => 'reportes.bdt@gmail.com',
                    ]
                ];
                self::envioPrioritarioDirecto($area, $data);

                // Enviar correo a supervisores Jorge - Saul -Naye
                self::envioDestinatariosDirecto($destinatarios, $data);
                break;



            default:
                $destinatario = 'reportes.bdt@gmail.com';
                $cc = 'reportes.bdt@gmail.com';
                Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                break;
        }




        return redirect()->route('consultar.ticket');
        // return $request->all();
    }

    public function validar(Request $request, tickets $ticket){
        $prioridad                  = $request->input('actualizar_prioridad');
        $nivel                      = $request->input('actualizar_nivel');

        $ticket->PRIORIDAD          = $prioridad;
        $ticket->NIVEL              = $nivel;

        $modificacion = new modificaciones;

        $modificacion->ID_TICKET    = $ticket->ID_TICKET;
        $modificacion->TIPO         = 'VALIDACION';
        $modificacion->RESPONSABLE  = 'Saul Delgadillo';
        $modificacion->FECHA        = date("Y-m-d H-i-s");


        $modificacion->save();

        $ticket->save();


        $area    = $ticket->afeccion->area_afeccion;

        $fotos      = self::generarArregloFotos($ticket);
        // Contenido del correo
        $data = [
            'nuevo_ticket' =>           true,
            'autorizacion_ticket' =>    false,

            'folio' =>          $ticket->FOLIO,
            'casa' =>           $ticket->CASA,
            'area' =>           $ticket->AREA_RESPONSABLE,

            'fecha_inicio' =>   $ticket->FECHA_INICIO,
            'estatus' =>        $ticket->ESTATUS_ACTUAL,
            'afeccion' =>       $ticket->AFECCION,
            'reinicidencia' =>  $ticket->REINCIDENCIA,
            'entorno' =>        $ticket->ENTORNO,
            'sitio' =>          $ticket->SITIO,
            'espacio' =>        $ticket->ESPACIO,
            'objeto' =>         $ticket->OBJETO,
            'elemento' =>       $ticket->ELEMENTO,
            'daño' =>           $ticket->DAÑO,
            'prioridad' =>      $ticket->PRIORIDAD,
            'nivel'=>           $ticket->NIVEL,
            'detalle' =>        $ticket->DETALLE,

            'fotos' =>          $fotos,
            'encript' =>        Crypt::encryptString('PERSONAL NO OBTENIDO'),
            'director' =>       $ticket->DIRECTOR,

            'ticket' =>         $ticket,
            'validado' =>       true,

        ];


        if ($area->NOMBRE == 'FYCSA') {
            self::envioPrioritario($nivel, $area, $data);
            $area = areas::where('NOMBRE', 'CTBR')->first();
            self::envioPrioritario($nivel, $area, $data);

        } else {
            self::envioPrioritario($nivel, $area, $data);
        }

        return redirect()->route('consultar.ticket');
    }

    public function cancelar(Request $request, tickets $ticket){
        $destinatario = $ticket->casa->CORREO;
        $cc = 'reportes.bdt@gmail.com';
        $data = [
            "folio" => $ticket->FOLIO,
            "casa" => $ticket->CASA,
            "area" => $ticket->AREA_RESPONSABLE,
            "mensaje" => $request->input('mensaje'),
        ];

        tickets::where('ID_TICKET', $ticket->ID_TICKET)->delete();

        // Baja de Imagenes
        self::eliminarFotoTicket($ticket->FOTO_OBLIGATORIA);
        self::eliminarFotoTicket($ticket->FOTO_2);
        self::eliminarFotoTicket($ticket->FOTO_3);


        self::enviarCorreoObservaciones($destinatario, $cc, $data);

        return redirect()->route('consultar.ticket');
        // return $request->all();
    }

    public function cotizar(Request $request, tickets $ticket, $usuario){

        $monto =                    $request->input('monto');
        $fecha_compromiso =         $request->input('fecha_compromiso');

        if (empty($monto)) {
            $ticket->ESTATUS_COTIZACION='NO';
            $ticket->COTIZACION =       null;
            $ticket->FECHA_COMPROMISO = $fecha_compromiso;

            // Carga y guardado de cotizaciones XLSX
            self::eliminarArchivoCotizacion($ticket->ARCHIVO_COTIZACION);
            $cotizacion_xls             = self::cargaCotizacion($request->file('archivo_opcional'));

            $ticket->ARCHIVO_COTIZACION = $cotizacion_xls;

            $ticket->save();

            $modificacion = new modificaciones;

            $modificacion->ID_TICKET    = $ticket->ID_TICKET;
            $modificacion->TIPO         = 'FECHA COMPROMISO';
            $modificacion->RESPONSABLE  = $usuario;
            $modificacion->FECHA        = date("Y-m-d H-i-s");

            if (!is_null($request->input('justificacion'))){
                $modificacion->JUSTIFICACION = $request->input('justificacion');
            }
            $modificacion->save();

            // NOTIFICAR FECHA COMPROMISO SIN CONSIDERAR AREA FINANZAS
            $cotizacion =                 false;
            self::envioCompromiso($ticket, $cotizacion);
        } else {
            $ticket->ESTATUS_COTIZACION='SI';
            $ticket->COTIZACION =       $monto;
            $ticket->FECHA_COMPROMISO = $fecha_compromiso;

            // Carga y guardado de cotizaciones XLSX
            self::eliminarArchivoCotizacion($ticket->ARCHIVO_COTIZACION);
            $cotizacion_xls             = self::cargaCotizacion($request->file('archivo_opcional'));

            $ticket->ARCHIVO_COTIZACION = $cotizacion_xls;

            $ticket->save();

            $modificacion = new modificaciones;

            $modificacion->ID_TICKET    = $ticket->ID_TICKET;
            $modificacion->TIPO         = 'COTIZACION';
            $modificacion->RESPONSABLE  = $usuario;
            $modificacion->FECHA        = date("Y-m-d H-i-s");

            if (!is_null($request->input('justificacion'))){
                $modificacion->JUSTIFICACION = $request->input('justificacion');
            }
            $modificacion->save();

            // NOTIFICAR COTIZACION CC-> AREA FINANZAS
            $cotizacion =               $monto;
            self::envioCompromiso($ticket, $cotizacion);
        }



        return redirect()->route('consultar.ticket');
    }

    public function autorizar(Request $request, tickets $ticket, $usuario){

        $ticket->ESTATUS_AUTORIZACION='SI';

        if (!is_null($request->file('archivo_firmado'))){
            // Carga y guardado de documento de autorizacion firmado
            self::eliminarArchivoAutorizacion($ticket->ARCHIVO_AUTORIZACION);
            $autorizacion                 = self::cargaAutorizacion($request->file('archivo_firmado'));

            $ticket->ARCHIVO_AUTORIZACION = $autorizacion;
        }else{
            $autorizacion                 = self::cargaAutorizacion($request->file('archivo_firmado'));
            $ticket->ARCHIVO_AUTORIZACION = $autorizacion;
        }

        $ticket->save();

        $modificacion = new modificaciones;

        $modificacion->ID_TICKET    = $ticket->ID_TICKET;
        $modificacion->TIPO         = 'AUTORIZACION';
        $modificacion->RESPONSABLE  = $usuario;
        $modificacion->FECHA        = date("Y-m-d H-i-s");

        if (!is_null($request->input('justificacion'))){
            $modificacion->JUSTIFICACION = $request->input('justificacion');
        }
        $modificacion->save();

        // NOTIFICAR AUTORIZACIONES
        $prioridad  = $ticket->PRIORIDAD;
        $nivel      = $ticket->NIVEL;
        $area       = $ticket->afeccion->area_afeccion;

        $fotos      = self::generarArregloFotos($ticket);
        // Contenido del correo
        $data = [
            'nuevo_ticket' =>           false,
            'autorizacion_ticket' =>    true,

            'folio' =>          $ticket->FOLIO,
            'casa' =>           $ticket->CASA,
            'area' =>           $ticket->AREA_RESPONSABLE,

            'fecha_inicio' =>   $ticket->FECHA_INICIO,
            'estatus' =>        $ticket->ESTATUS_ACTUAL,
            'afeccion' =>       $ticket->AFECCION,
            'reinicidencia' =>  $ticket->REINCIDENCIA,
            'entorno' =>        $ticket->ENTORNO,
            'sitio' =>          $ticket->SITIO,
            'espacio' =>        $ticket->ESPACIO,
            'objeto' =>         $ticket->OBJETO,
            'elemento' =>       $ticket->ELEMENTO,
            'daño' =>           $ticket->DAÑO,
            'prioridad' =>      $ticket->PRIORIDAD,
            'nivel' =>          $ticket->NIVEL,
            'detalle' =>        $ticket->DETALLE,

            'monto' =>          $ticket->COTIZACION,
            'fecha_compromiso'=>$ticket->FECHA_COMPROMISO,

            'fotos' =>          $fotos,
            'director' =>       $ticket->DIRECTOR,

            'ticket' =>         $ticket,
        ];

        if ($area->NOMBRE == 'FYCSA') {
            self::envioPrioritario($nivel, $area, $data);

            $area = areas::where('NOMBRE', 'CTBR')->first();
            self::envioPrioritario($nivel, $area, $data);

        } else {
            self::envioPrioritario($nivel, $area, $data);
        }


        return redirect()->route('consultar.ticket');
    }

    public function actualizar(Request $request, tickets $ticket){

        $ticket->FECHA_FIN = $request->input('fecha_termino');
        $ticket->AREA_ATENCION = $request->input('area_atendio');
        $ticket->PERSONA_ATENCION = $request->input('persona_atendio');
        $ticket->ESTATUS_ACTUAL = $request->input('actualizar_estatus');
        $ticket->EVIDENCIA = $request->input('link_evidencia');
        $ticket->OBSERVACIONES = $request->input('observaciones_finales');

        $ticket->save();

        return redirect()->route('consultar.ticket');
    }

    public function consultar(Request $request){
        $dateStart = $request->input('fecha_inicio');
        $dateEnd = $request->input('fecha_termino');


        $archivo = new consultaCompuestaTickets($dateStart, $dateEnd);
        $archivo->descargar();
    }

    // Personal
    public function crearPersonal(Request $request){
        $nombre =       $request->input('nombre');
        $puesto =       $request->input('puesto');
        $area =         $request->input('areas');
        $correo =       $request->input('correo');

        // // Rellenar BD encargados_table
        $encargado = new encargados;

        $encargado->ID_AREA =  $area;
        $encargado->NOMBRE =   $nombre;
        $encargado->PUESTO =   $puesto;
        $encargado->CORREO =   $correo;

        $encargado->save();

        return redirect()->route('modificar.personal');
        // return $request->all();
    }

    public function asignarPersonal(Request $request){
        $encargado =    $request->input('encargados');
        $casa =         $request->input('casas');


        // Rellenar BD encargados_casas_table
        $relacion = new encargados_casas;

        $relacion->ID_ENCARGADO =   $encargado;
        $relacion->ID_CASA =        $casa;

        $relacion->save();


        return redirect()->route('modificar.personal');
    }

    public function eliminarPersonal(Request $request){
        $encargado = $request->input('encargados_delete');
        encargados::where('ID_ENCARGADO', $encargado)->delete();

        return redirect()->route('modificar.personal');
    }

    public function eliminarRelacionPersonal(Request $request){
        $relaciones = $request->encargado_casa;

        if ($relaciones != null) {

            foreach ($relaciones as $relacion) {
                encargados_casas::where('ID_ENCARGADOS_CASAS',$relacion)->delete();
            }

        return redirect()->route('modificar.personal');

        }else {
            return redirect()->route('modificar.personal');
        }
    }



// CARGA/BAJA IMAGENES y OBTENCION NOMBRE
    public function cargaImg($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_foto =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_evidencias')->put($nombre_foto,  \File::get($file));

            return $nombre_foto;
        }
    }

    public function eliminarFotoTicket($nombre_foto){
        if ($nombre_foto != null) {
            // $nombre_foto = '1728068080_1.jpg';
            \Storage::disk('tickets_evidencias')->delete($nombre_foto);
            # code...
        }
    }

    public function generarArregloFotos($ticket){
        // Carga y guardado de Imagenes
        $foto_1 =             $ticket->FOTO_OBLIGATORIA;
        $foto_2 =             $ticket->FOTO_2;
        $foto_3 =             $ticket->FOTO_3;
        $arreglo_fotos =      [$foto_1, $foto_2, $foto_3];

        // Devolver arreglo sin fotos vacías
        $fotos = array_filter($arreglo_fotos, function($item){
            return !empty($item);
        });


        return $fotos;
    }

// CARGA/BAJA DOCUMENTOS y OBTENCION NOMBRE
    public function cargaCotizacion($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_archivo =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_cotizaciones')->put($nombre_archivo,  \File::get($file));


            return $nombre_archivo;
        }
    }

    public function cargaAutorizacion($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_archivo =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_autorizaciones')->put($nombre_archivo,  \File::get($file));

            return $nombre_archivo;
        }
    }

    public function eliminarArchivoCotizacion($nombre_archivo){
        if ($nombre_archivo != null) {
            // $nombre_foto = '1728068080_1.jpg';
            \Storage::disk('tickets_cotizaciones')->delete($nombre_archivo);
        }
    }

    public function eliminarArchivoAutorizacion($nombre_archivo){
        if ($nombre_archivo != null) {
            \Storage::disk('tickets_autorizaciones')->delete($nombre_archivo);
        }
    }

// Validación de ID adjuntos y nulos
    public function validarNulos($valor, $coleccion){
        if (empty($valor)){
            return '---';
        }
        else{
            return $coleccion[$valor-1]->NOMBRE;
        }
    }

// ENVIOS CORREOS
    public function envioPrioritario($nivel, $area, $data){

        // Enviar correo a encargados
        // $area    = $ticket->afeccion->area_afeccion;
        $data['area'] = $area->NOMBRE;

        $supervisor = $data['ticket']->casa->supervisor_casa->where('ID_AREA', $area->ID_AREA)->first();
        $subgerente = $data['ticket']->casa->subgerente_casa->where('ID_AREA', $area->ID_AREA)->first();
        $gerente    = $data['ticket']->casa->gerente_casa->where('ID_AREA', $area->ID_AREA)->first();


        switch ($nivel) {
            case 'GERENCIA':
                // NOTIFICAR GERENTE SI EXISTE
                if ($gerente) {
                    $data['destinatario']  = $gerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($gerente->NOMBRE);

                    $destinatario = 'mangel.jimenez@telmexeducacion.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }

                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = 'jimenez.vazquez.miguel.a@gmail.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = 'miguelangelzz2900@gmail.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }
                break;

            case 'SUBGERENCIA':
                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = 'jimenez.vazquez.miguel.a@gmail.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = 'miguelangelzz2900@gmail.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }
                break;

            case 'SUPERVISION':
                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = 'miguelangelzz2900@gmail.com';
                    $cc = ['reportes.bdt@gmail.com'];

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->cc($cc)->send(new AutorizacionTicket($data));
                    }
                }
                break;
            }
    }

    public function envioPrioritarioDirecto($area, $data){

        // Enviar correo a encargados
        // $area    = $ticket->afeccion->area_afeccion;
        $data['area'] = $area->NOMBRE;

        $supervisor = $data['ticket']->casa->supervisor_casa->where('ID_AREA', $area->ID_AREA)->first();
        $subgerente = $data['ticket']->casa->subgerente_casa->where('ID_AREA', $area->ID_AREA)->first();
        $gerente    = $data['ticket']->casa->gerente_casa->where('ID_AREA', $area->ID_AREA)->first();

        // NOTIFICAR GERENTE SI EXISTE
        if ($gerente) {
            $data['destinatario']  = $gerente->NOMBRE;
            $data['encript']    = Crypt::encryptString($gerente->NOMBRE);

            $destinatario = 'mangel.jimenez@telmexeducacion.com';
            $cc = ['reportes.bdt@gmail.com'];
            Mail::to($destinatario)->cc($cc)->send(new NotificacionTicketDirecto($data));

        }

        // NOTIFICAR SUBGERENTE SI EXISTE
        if ($subgerente) {
            $data['destinatario'] = $subgerente->NOMBRE;
            $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

            $destinatario = 'jimenez.vazquez.miguel.a@gmail.com';
            $cc = ['reportes.bdt@gmail.com'];

            Mail::to($destinatario)->cc($cc)->send(new NotificacionTicketDirecto($data));

        }

        // NOTIFICAR SUPERVISOR SI EXISTE
        if ($supervisor) {
            $data['destinatario'] = $supervisor->NOMBRE;
            $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

            $destinatario = 'miguelangelzz2900@gmail.com';
            $cc = ['reportes.bdt@gmail.com'];

            Mail::to($destinatario)->cc($cc)->send(new NotificacionTicketDirecto($data));

        }

    }

    public function envioDestinatariosDirecto($destinatarios, $data){
        foreach ($destinatarios['supervisores'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            $data['supervisor']     = true;
            Mail::to($correo)->send(new NotificacionTicketDirecto($data));
        }
    }

    public function envioCompromiso($ticket, $cotizacion){
        // Carga y guardado de Imagenes para correo
        $foto_1 =             $ticket->FOTO_OBLIGATORIA;
        $foto_2 =             $ticket->FOTO_2;
        $foto_3 =             $ticket->FOTO_3;
        $arreglo_fotos =      [$foto_1, $foto_2, $foto_3];

        // Devolver arreglo sin fotos vacías
        $fotos = array_filter($arreglo_fotos, function($item){
            return !empty($item);
        });


        // NOTIFICACION
        // Enviar correo a encargados de finanzas, Saul, Jorge
        $id_finanzas = areas::where('NOMBRE','Finanzas Filiales')->first()->ID_AREA;
        $encargados_finanzas = $ticket->casa->encargados_casa->where('ID_AREA', $id_finanzas);

        $destinatarios = [
            'supervisores' => [
                'Jorge Leybon' => 'reportes.bdt@gmail.com',
                'Saul Delgadillo' => 'reportes.bdt@gmail.com',
            ],
            'finanzas' => [

            ]
        ];
        foreach ($encargados_finanzas as $encargado) {
            // CAMBIAR CORREO ESTÁTICO POR DINÁMICO
            $destinatarios['finanzas'] += [$encargado->NOMBRE => 'reportes.bdt@gmail.com'];
        }

        // Contenido del correo
        $data = [
            'folio' =>          $ticket->FOLIO,
            'casa' =>           $ticket->CASA,
            'area' =>           $ticket->AREA_RESPONSABLE,

            'fecha_inicio' =>   $ticket->FECHA_INICIO,
            'estatus' =>        $ticket->ESTATUS_ACTUAL,
            'afeccion' =>       $ticket->AFECCION,
            'reinicidencia' =>  $ticket->REINCIDENCIA,
            'entorno' =>        $ticket->ENTORNO,
            'sitio' =>          $ticket->SITIO,
            'espacio' =>        $ticket->ESPACIO,
            'objeto' =>         $ticket->OBJETO,
            'elemento' =>       $ticket->ELEMENTO,
            'daño' =>           $ticket->DAÑO,
            'prioridad' =>      $ticket->PRIORIDAD,
            'detalle' =>        $ticket->DETALLE,


            'fecha_compromiso'=>$ticket->FECHA_COMPROMISO,
            'monto' =>          $ticket->COTIZACION,

            'director' =>       $ticket->DIRECTOR,
            'ticket' =>         $ticket,
            'fotos' =>          $fotos,

            'supervisor_bdt' =>     false,
        ];

        // Enviar correo a supervisores Jorge - Saul
        foreach ($destinatarios['supervisores'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            $data['supervisor_bdt']     = true;

            Mail::to($correo)->send(new CotizacionTicket($data));
        }

        // SI HUBO COTIZACION
        // Enviar correo a Finanzas Andrés Becerril - Maricarmen Ruiz
        if ($cotizacion) {
            foreach ($destinatarios['finanzas'] as $nombre => $correo) {
                $data['destinatario'] = $nombre;
                $data['supervisor_bdt']   = false;

                Mail::to($correo)->send(new CotizacionTicket($data));
            }
        }
    }



    public function enviarCorreoObservaciones($destinatario, $cc, $data){
        Mail::to($destinatario)->cc($cc)->send(new ObservacionesTicket($data));
    }



    public function enviarCorreoPrueba($destinatario, $cc, $data){

        Mail::to($destinatario)->cc($cc)->send(new ReporteQuincenalCompleto($data));
        Mail::to($destinatario)->cc($cc)->send(new ReporteQuincenalCT($data));
        Mail::to($destinatario)->cc($cc)->send(new ReporteQuincenalResumen($data));
    }

// EXPORTACIONES EXCEL
    public function export_historico(){
        return Excel::download(new ticketsExport, 'tickets-historico.xlsx');
    }
    public function export_status(){
        return Excel::download(new ticketsstatusExport, 'tickets-status.xlsx');
    }
    public function export_dinamic_ticket(){
        $dateStart = Carbon::now()->startOfMonth()->subMonth(3);
        // $dateEnd = Carbon::now()->startOfDay()->subDays(5);
        $dateEnd = Carbon::now();

        $import = new ticketDinamico($dateStart, $dateEnd);

        $import->onlySheets('Detalle General', 'Estatus Contabilizado');
        // $import->onlySheets('Detalle General');

        return Excel::download($import, 'Consulta-Mantenimientos.xlsx');
    }

    public function exportCotizacion($nombre_archivo){

        $path = \Storage::disk('tickets_cotizaciones')->path($nombre_archivo);

        return response()->download($path);
    }

    public function exportAutorizacion($nombre_archivo){

        $path = \Storage::disk('tickets_autorizaciones')->path($nombre_archivo);

        return response()->download($path);
    }
}

