<?php

namespace App\Http\Controllers;

// Controlador de Modelos
use DB;
use Auth;


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
use App\coordinadores;
use App\tickets;

use App\encargados;
use App\encargados_casas;

use App\modificaciones;
use App\User;


// Controlador de correos
use Illuminate\Support\Facades\Mail;
use App\Mail\ReporteQuincenalCompleto;
use App\Mail\ReporteQuincenalCT;
use App\Mail\ReporteQuincenalResumen;

use App\Mail\GeneracionTicket;
use App\Mail\ObservacionesTicket;
use App\Mail\CotizacionTicket;
use App\Mail\AutorizacionTicket;
use App\Mail\AnulacionTicket;
use App\Mail\NotificacionTicketDirecto;
use App\Mail\ReporteMensualMantenimientos;
use App\Mail\RecordatorioTicketNoCotizado;

// Obtención de campos
use Illuminate\Http\Request;

// Dependencias de Excel
use App\Exports\consultaCompuestaTicketsPendientes;
use App\Exports\consultaCompuestaTickets;
use App\Exports\consultaCompuestaSedena;
use App\Exports\consultaCompuestaSemar;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ticketResumenGeneral;
use App\Exports\ticketEstatusDetalle;
use App\Exports\ticketsExport;


// Namespace para fechas
use Carbon\Carbon;

// Namespace para encriptacióon de cadenas
use Illuminate\Support\Facades\Crypt;

// NameSpace Telegram
use App\Http\Controllers\TelegramController;


class TicketsController extends Controller
{
    public function __construct()
    {
        // $this->strroute = 'storage/app/public/tickets/evidencias/';
        $this->strroute = 'storage/tickets/evidencias/';
        // $this->middleware('auth');
    }




// CONSULTAS FETCH JS
    public function obtenerCasas($id){
        // $casa = casas::find($id);
        return casas::where('ID_CASA', $id)->first();
    }

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
        //14,15,16->Afecciones Base Pasada
        // IGNORAR AFECCIONES QUE NO LE CORRESPONDEN ALDEA
        if ($casa->ID_CASA == 1){
            // IGNORAR ->DETERIORO, INFRAESTRUCTURA , SEGURIDAD -> (INDIVIDUAL)
            $ignorarAfecciones = [3,6,11,14,15,16];
        }else{
            // IGNORAR ->DETERIORIOROS, INFRAESTRUCTURAS, SEGURIDAD ALDEA ->POR ENTORNO(INTERNOS EXTERNOS)
            $ignorarAfecciones = [4,5, 7,8, 12,14,15,16];
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
        // No considerar casas no existentes admin
        $casas = casas::whereNotIn('ID_CASA',[11,12,13])->get();

        if (Auth::user()->rol == 'director') {
            $casaDirector =  casas::where('ID_CASA', Auth::user()->userable->casa->ID_CASA)->first();
        }


        $tipos_danos = tipos_danos::all();

        $entornos = entornos::all();

        // Formato de folio RM-AÑO/ID_NUEVO-CASA(ABREVIADO)
        $folio  = '[RM-' .  date("Y") . ']-';

        $id_ticket = tickets::select('ID_TICKET')->orderBy('ID_TICKET', 'desc')->first();

        // Folio 1 cuando esté vacío
        if (is_null($id_ticket)){ $folio .= '1';}
        else{ $folio .= $id_ticket->ID_TICKET + 1;}

        $folio .= '-';

        return view('Tickets.crearticket',
        compact(
            'casas', 'casaDirector', 'directores', 'drives',
            'tipos_danos', 'afecciones', 'areas',
            'entornos','sitios', 'espacios',
            'objetos', 'elementos_objetos', 'folio'
        ));
    }

    public function consultarTickets(){
        switch (Auth::user()->rol) {
            case 'coordinador':
                $currentYear = date('Y');
                $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->orderBy('FECHA_INICIO', 'DESC')->get();
                break;
            case 'director':
                $currentYear = date('Y');
                $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->where('ID_CASA', Auth::user()->userable->casa->ID_CASA)
                ->orderBy('FECHA_INICIO', 'DESC')->get();
                break;

            default:
                $currentYear = date('Y');
                $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->orderBy('FECHA_INICIO', 'DESC')->get();
                break;
        }
        return view('Tickets.consultarticket', compact('tickets'));

        // foreach (Auth::user()->userable->casa as $casa) {
        //     echo $casa->ID_CASA;
        // }
    }

    public function generaReporteTickets(){
        $now = Carbon::now()->format("Y-m-d");
        $startWeek = Carbon::now()->startOfWeek()->format("Y-m-d");

        return view('Tickets.generarreporte', compact('now', 'startWeek'));
    }

    public function actualizarTickets(tickets $ticket){
        $id_siniestros =  DB::table('areas')->select('ID_AREA')->where('NOMBRE', 'Siniestros')->first()->ID_AREA;
        $id_aliadosTec =  DB::table('areas')->select('ID_AREA')->where('NOMBRE', 'Aliados Tecnológicos')->first()->ID_AREA;

        $areas = areas::whereNotIn('ID_AREA',[$id_siniestros,$id_aliadosTec])->get();
        $strroute = $this->strroute;

        return view('Tickets.actualizarticket', compact('ticket', 'areas', 'strroute'));
    }

    public function historialTickets(tickets $ticket){
        $modificaciones = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->orderBy('FECHA', 'DESC')->get();

        return view('Tickets.historialticket', compact('modificaciones', 'ticket'));
    }



    public function validarTickets(tickets $ticket, $encargado){
        $prioridades = prioridades::all();

        if ($ticket->modificaciones->where('TIPO', 'VALIDACION')->isEmpty()) {
            $validado = false;

            $strroute = $this->strroute;
            return view('Tickets.validarticket', compact('ticket','encargado', 'prioridades', 'validado', 'strroute'));
        } else {
            $validado = true;
            $ultimaValidacion = $ticket->modificaciones->where('TIPO', 'VALIDACION')->first();
            return view('Tickets.validarticket', compact('ticket','encargado', 'prioridades', 'validado', 'ultimaValidacion'));

        }

    }

    public function cotizarTickets(tickets $ticket, $encargado){
        $ultimaCotizacion = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','COTIZACION')->orderBy('FECHA','DESC')->first();
        $ultimaFechaCompromiso = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','FECHA COMPROMISO')->orderBy('FECHA','DESC')->first();
        $decrypted = Crypt::decryptString($encargado);

        $strroute = $this->strroute;
        return view('Tickets.cotizarticket', compact('ticket', 'encargado', 'decrypted', 'ultimaCotizacion', 'ultimaFechaCompromiso', 'strroute'));
    }

    public function modificarCotizacion(tickets $ticket, $encargado) {
        $decrypted = Crypt::decryptString($encargado);

        $strroute = $this->strroute;
        return view('Tickets.modifiicarcotizacionticket', compact('ticket', 'decrypted', 'strroute'));
    }

    public function autorizarTicket(tickets $ticket, $encargado){
        $ultimaCotizacion = modificaciones::where('ID_TICKET', $ticket->ID_TICKET)->where('TIPO','COTIZACION')->orderBy('FECHA','DESC')->first();
        $decrypted = Crypt::decryptString($encargado);

        $strroute = $this->strroute;
        return view('Tickets.autorizarticket', compact('ticket', 'encargado', 'decrypted', 'ultimaCotizacion', 'strroute'));
    }


    public function modificarPersonal(){

        // No considerar casas no existentes
        $casas = casas::whereNotIn('ID_CASA',[11,12,13])->get();

        $areas = areas::whereNotIn('ID_AREA',[13])->get();
        $encargados = encargados::all();
        $encargados_casas = encargados_casas::all();

        $tickets = tickets::all();


        return view('Tickets.personal', compact('casas', 'areas', 'encargados', 'encargados_casas', 'tickets'));

    }


    public function consultarTicketsPago(){
        $currentYear = date('Y');

        $ticketsFinalizados = tickets::whereYear('FECHA_INICIO', $currentYear)->where([
            ['ESTATUS_ACTUAL', 'FINALIZADO'],
            ['AREA_RESPONSABLE','<>','SEDENA'],
            ['AREA_RESPONSABLE','<>','SEMAR'],
            ['DAÑO','<>','Siniestro - Desastre Meteorilógico'],
            ['DAÑO','<>','Siniestro - Temblor'],
            ['REINCIDENCIA','<>','SI'],

        ])->orderBy('FECHA_INICIO', 'DESC')->get();

        $ticketsPendientes = tickets::whereYear('FECHA_INICIO', $currentYear)->where([
            ['AREA_RESPONSABLE','<>','SEDENA'],
            ['AREA_RESPONSABLE','<>','SEMAR'],

            ['DAÑO','<>','Siniestro - Desastre Meteorilógico'],
            ['DAÑO','<>','Siniestro - Temblor'],

            // CORRECION
            ['REINCIDENCIA','<>','SI'],

            ['ESTATUS_AUTORIZACION','<>','SI'],
            ['ESTATUS_AUTORIZACION','<>','ANULADO'],
            ['ESTATUS_AUTORIZACION','<>','CANCELADO'],
            ['ESTATUS_ACTUAL','PENDIENTE'],

            ['ESTATUS_COTIZACION','NO'],
            ['FECHA_COMPROMISO',NULL],

            ['COTIZACION',0],

        ])->orderBy('FECHA_INICIO', 'DESC')->get();


        $coordinador = Auth::user()->userable->NOMBRE;
        $encrypted = Crypt::encryptString($coordinador);

        return view('Tickets.consultarTicketsPago', compact('ticketsFinalizados', 'ticketsPendientes', 'encrypted'));

    }

    public function actualizarTicketsFinalizados(tickets $ticket, $encrypted){
        $strroute = $this->strroute;
        $usuario =  Crypt::decryptString($encrypted);

        return view('Tickets.actualizarpagoticket', compact('ticket', 'strroute', 'usuario'));
    }

    public function cotizarTicketsPendientes(tickets $ticket, $encrypted){
        $strroute = $this->strroute;
        $decrypted = Crypt::decryptString($encrypted);

        return view('Tickets.cotizarTicketPendiente', compact('ticket', 'strroute', 'decrypted'));
    }

    public function consultarTicketsPasados(){

        $tickets = tickets::where([
            ['FOTO_OBLIGATORIA',NULL],
            ['EVIDENCIA_TERMINO',NULL],

            ])->where('ID_CASA', Auth::user()->userable->casa->ID_CASA)
            ->orderBy('FECHA_INICIO', 'DESC')->get();

        return view('Tickets.consultarTicketsPasados', compact('tickets'));

    }

    public function actualizarTicketsPasados(tickets $ticket){
        $strroute = $this->strroute;

        return view('Tickets.actualizarEvidenciaTicket', compact('ticket', 'strroute'));
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
        $foto_1 =             self::cargaImgEvidencia($request->file('foto_obligatoria'));
        $foto_2 =             self::cargaImgEvidencia($request->file('foto_opcional_2'));
        $foto_3 =             self::cargaImgEvidencia($request->file('foto_opcional_3'));
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
        $ticket->ESTATUS_COTIZACION =    'NO';
        $ticket->ESTATUS_AUTORIZACION =  'NO';
        $ticket->ESTATUS_ACTUAL =   $estatus_actual;
        $ticket->ESTATUS_PAGO =          'NO';

        $ticket->save();

        $modificacion = new modificaciones;

        $modificacion->ID_TICKET    = $ticket->ID_TICKET;
        $modificacion->TIPO         = 'CREACION';
        $modificacion->RESPONSABLE  = $casa;
        $modificacion->FECHA        = date("Y-m-d H-i-s");

        $modificacion->save();


        // $area    = $ticket->afeccion->area_afeccion;

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

        // Enviar correo a Vo.Bo.
        $telegram = new TelegramController();

        foreach ($ticket->casa->coordinador_casa as $coordinador) {
            if ($coordinador->VALIDACION == true) {
                $data['destinatario'] = $coordinador->NOMBRE;
                self::enviarNuevoTicket($data, $coordinador->CORREO);

                $payload = "<b>NUEVO TICKET A VALIDAR</b>%0A".
                $ticket->CASA. " - ".$ticket->AREA_RESPONSABLE. " - ".$ticket->AFECCION;

                $telegram->sendText($coordinador->TELEGRAM, $payload);
            }
        }

        return redirect()->route('consultar.ticket');
        // return $request->all();
    }

    public function validar(Request $request, tickets $ticket, $usuario){
        $prioridad                  = $request->input('actualizar_prioridad');
        $nivel                      = $request->input('actualizar_nivel');

        $ticket->PRIORIDAD          = $prioridad;
        $ticket->NIVEL              = $nivel;

        $modificacion = new modificaciones;

        $modificacion->ID_TICKET    = $ticket->ID_TICKET;
        $modificacion->TIPO         = 'VALIDACION';
        $modificacion->RESPONSABLE  = $usuario;
        $modificacion->FECHA        = date("Y-m-d H-i-s");


        $modificacion->save();

        $ticket->save();


        $area             = $ticket->afeccion->area_afeccion;
        $area_responsable = $ticket->afeccion->area_afeccion->NOMBRE;

        $fotos      = self::generarArregloFotos($ticket);
        // Contenido del correo
        $data = [
            'nuevo_ticket' =>           true,
            'autorizacion_ticket' =>    false,
            'anulacion_ticket' =>       false,

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

        switch (true) {
            // SINIESTROS
            case ($ticket->ID_TIPO_DANO == 1 || $ticket->ID_TIPO_DANO == 2):
                self::notificarAreasDirecto($nivel, $area_responsable, $area, $data);

                $area = areas::where('NOMBRE', 'Siniestros')->first();
                self::envioPrioritarioDirecto($nivel, $area, $data);
                break;

            // REINCIDENCIA
            case ($ticket->REINCIDENCIA == 'SI'):
                self::notificarAreasDirecto($nivel, $area_responsable, $area, $data);
                break;

            // SDN - SEMAR
            case ($ticket->AREA_RESPONSABLE == 'SEDENA' || $ticket->AREA_RESPONSABLE == 'SEMAR'):
                self::notificarAreasDirecto($nivel, $area_responsable, $area, $data);
                break;

            default:
                if ($area->NOMBRE == 'FYCSA') {
                    self::envioPrioritario($nivel, $area, $data);

                    $area = areas::where('NOMBRE', 'CTBR')->first();
                    self::envioPrioritario($nivel, $area, $data);

                } else {
                    self::envioPrioritario($nivel, $area, $data);
                }

                $destinatarios = self::obtenerDestinatarios($ticket);
                // Notificar a destinatarios extra SDN SEMAR
                foreach ($destinatarios['extra'] as $nombre => $correo) {
                    $data['destinatario']   = $nombre;
                    $data['encript']        = Crypt::encryptString($nombre);
                    $data['supervisor']     = false;
                    Mail::to($correo)->send(new NotificacionTicketDirecto($data));
                }

                //Notificar TELEGRAM ($destinatario, data)
                $telegram = new TelegramController();

                foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
                    $payload = "<b>NUEVO TICKET GENERADO - ".$ticket->FOLIO."</b>%0A".
                    $ticket->CASA. " - ".$ticket->AREA_RESPONSABLE. " - ".$ticket->AFECCION;
                    $telegram->sendText($chat_id, $payload);
                }
                break;
        }


        return redirect()->route('consultar.ticket');
    }

    public function cancelar(Request $request, tickets $ticket){
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

        $destinatario = $ticket->casa->director->CORREO;
        self::enviarCorreoObservaciones($destinatario, $data);

        if (!empty($ticket->casa->CORREO)) {
            $destinatario = $ticket->casa->CORREO;
            // AÑADIR USUARIO CASA
            self::enviarCorreoObservaciones($destinatario, $data);
        }

        return redirect()->route('consultar.ticket');
        // return $request->all();
    }

    public function cotizar(Request $request, tickets $ticket, $usuario){

        $monto =                    $request->input('monto');
        $fecha_compromiso =         $request->input('fecha_compromiso') == "" ? null : $request->input('fecha_compromiso');

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
            $aux = '<b>NUEVO TICKET COMPROMETIDO - ';
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
            $aux = '<b>NUEVO TICKET COTIZADO - ';

        }


        //Notificar TELEGRAM ($destinatario, data)
        $telegram = new TelegramController();
        $destinatarios = self::obtenerDestinatarios($ticket);

        foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
            $payload= $aux. $ticket->FOLIO .'</b>%0A'.
            $ticket->CASA.' - '.$ticket->AREA_RESPONSABLE.
            '%0A %0A Por: '.$usuario;
            $telegram->sendText($chat_id, $payload);
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
            'anulacion_ticket' =>       false,

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

        // Notificar a finanzas
        $area = areas::where('NOMBRE', 'Finanzas Filiales')->first();
        self::envioPrioritario($nivel, $area, $data);

        //Notificar TELEGRAM ($destinatario, data)
        $telegram = new TelegramController();
        $destinatarios = self::obtenerDestinatarios($ticket);

        foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
            $payload= "<b>NUEVO TICKET AUTORIZADO - ". $ticket->FOLIO.'</b>%0A %0A'.
            '- Actualización de ticket por: '.$usuario;
            $telegram->sendText($chat_id, $payload);
        }

        return redirect()->route('consultar.ticket');
    }

    public function anular(Request $request, tickets $ticket, $usuario){

        $destinatarios = self::obtenerDestinatarios($ticket);
        $data = [
            'nuevo_ticket' =>           false,
            'autorizacion_ticket' =>    false,
            'anulacion_ticket' =>       true,

            "folio"             => $ticket->FOLIO,
            "casa"              => $ticket->CASA,
            "area"              => $ticket->afeccion->area_afeccion,
            "mensaje"           => $request->input('mensaje'),

            'nivel'             => $ticket->NIVEL,
            "ticket"            => $ticket,

        ];



        // Baja de Imagenes
        self::eliminarFotoTicket($ticket->FOTO_OBLIGATORIA);
        self::eliminarFotoTicket($ticket->FOTO_2);
        self::eliminarFotoTicket($ticket->FOTO_3);
        self::eliminarArchivoCotizacion($ticket->ARCHIVO_COTIZACION);

        $ticket->ARCHIVO_COTIZACION = null;
        $ticket->ESTATUS_AUTORIZACION = 'ANULADO';
        $ticket->ESTATUS_ACTUAL = 'ANULADO';
        $ticket->save();


        $modificacion = new modificaciones;

        $modificacion->ID_TICKET    = $ticket->ID_TICKET;
        $modificacion->TIPO         = 'ANULACION';
        $modificacion->RESPONSABLE  = $usuario;
        $modificacion->FECHA        = date("Y-m-d H-i-s");


        $modificacion->save();

        self::enviarCorreoAnulacion($destinatarios, $data);

        //Notificar TELEGRAM ($destinatario, data)
        $telegram = new TelegramController();

        foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
            $payload= "<b>NUEVO TICKET NO AUTORIZADO - ". $ticket->FOLIO .'</b>%0A %0A'.
            '- ACTUALIZADO POR: '.$usuario;
            $telegram->sendText($chat_id, $payload);
        }

        return redirect()->route('consultar.ticket');
    }

    public function actualizar(Request $request, tickets $ticket){
        // return $request->all();
        $ticket->FECHA_FIN              = $request->input('fecha_termino');
        $ticket->AREA_ATENCION          = $request->input('area_atendio');
        $ticket->PERSONA_ATENCION       = $request->input('persona_atendio');
        $ticket->ESTATUS_ACTUAL         = $request->input('actualizar_estatus');
        // $ticket->EVIDENCIA = $request->input('link_evidencia');
        $ticket->OBSERVACIONES          = $request->input('observaciones_finales');

        // Baja de Imagenes
        self::eliminarFotoTicketActualizado($ticket->EVIDENCIA_TERMINO);
        self::eliminarFotoTicketActualizado($ticket->EVIDENCIA_TERMINO_2);
        self::eliminarFotoTicketActualizado($ticket->EVIDENCIA_TERMINO_3);

        // Carga y guardado de Imagenes
        $foto_1 =             self::cargaImgEvidenciaTermino($request->file('foto_obligatoria'));
        $foto_2 =             self::cargaImgEvidenciaTermino($request->file('foto_opcional_2'));
        $foto_3 =             self::cargaImgEvidenciaTermino($request->file('foto_opcional_3'));

        $ticket->EVIDENCIA_TERMINO      = $foto_1;
        $ticket->EVIDENCIA_TERMINO_2    = $foto_2;
        $ticket->EVIDENCIA_TERMINO_3    = $foto_3;


        $modificacion = new modificaciones;

        $modificacion->ID_TICKET        = $ticket->ID_TICKET;
        $modificacion->TIPO             = 'ACTUALIZACION ESTATUS - ' . $request->input('actualizar_estatus');
        $modificacion->RESPONSABLE      = $request->input('persona_atendio');
        $modificacion->JUSTIFICACION    = $request->input('observaciones_finales');
        $modificacion->FECHA            = date("Y-m-d H-i-s");

        $modificacion->save();

        $ticket->save();


        //Notificar TELEGRAM ($destinatario, data)
        $telegram = new TelegramController();
        $destinatarios = self::obtenerDestinatarios($ticket);

        foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
            $payload= "<b>ACTUALIZACION ESTATUS - ". $request->input('actualizar_estatus'). ' - '. $ticket->FOLIO .'</b>%0A %0A'.
            $ticket->CASA.' - ' . $request->input('area_atendio').': %0A'.$request->input('observaciones_finales');
            $telegram->sendText($chat_id, $payload);
        }

        return redirect()->route('consultar.ticket');
    }

    public function consultar(Request $request){
        $dateStart = $request->input('fecha_inicio');
        $dateEnd = $request->input('fecha_termino');

        $archivo = new consultaCompuestaTickets($dateStart, $dateEnd);

        $archivo->descargar();

    }

    public function consultarHistorico(){
        // Cambiar clase
        $archivo = new consultaCompuestaTicketsPendientes();
        $archivo->descargar();
    }


    // Personal
    public function crearPersonal(Request $request){
        $area =         $request->input('areas');
        $nombre =       $request->input('nombre');
        $puesto =       $request->input('puesto');
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

    public function asignarCorreo(Request $request){
        $casa =         casas::where( 'ID_CASA',$request->input('casas'))->first();
        $correo =       $request->input('correo_assign');

        $casa->CORREO = $correo;
        $casa->save();
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


    // Tickets Finalizados
    public function actualizarFinalizado(Request $request, tickets $ticket, $usuario){
        $evidencia_pago = $request->input('archivo_pago');

        if ($evidencia_pago) {
            // Carga y guardado de evidencias de pago
            self::eliminarEvidenciaPago($ticket->EVIDENCIA_PAGO);
            $archivo_pago               = self::cargaEvidenciaPago($request->file('archivo_pago'));

            $ticket->EVIDENCIA_PAGO     = $archivo_pago;
        }

        $ticket->ESTATUS_PAGO       = 'SI';

        $modificacion = new modificaciones;

        $modificacion->ID_TICKET        = $ticket->ID_TICKET;
        $modificacion->TIPO             = 'ACTUALIZACION ESTATUS - PAGADO';
        $modificacion->RESPONSABLE      = $usuario;
        $modificacion->FECHA            = date("Y-m-d H-i-s");

        $modificacion->save();

        $ticket->save();

        //Notificar TELEGRAM ($destinatario, data)
        $telegram = new TelegramController();
        $destinatarios = self::obtenerDestinatarios($ticket);

        foreach ($destinatarios['coordinadores-tel'] as $nombre => $chat_id) {
            $payload= ' <b>ACTUALIZACION ESTATUS - PAGADO - '. $ticket->FOLIO .'</b>%0A'.
            $ticket->CASA.' - '.$ticket->AREA_RESPONSABLE.
            '%0A %0A Por: '.$usuario;
            $telegram->sendText($chat_id, $payload);
        }

        return redirect()->route('consultar.ticket.pago');
    }

    public function actualizarPasado(Request $request, tickets $ticket){
        // Carga y guardado de evidencia
        $evidencia_inicio           = self::cargaImgEvidencia($request->file('foto_inicio'));
        $ticket->FOTO_OBLIGATORIA   = $evidencia_inicio;

        if ($ticket->ESTATUS_ACTUAL == "FINALIZADO") {
            // Carga y guardado de evidencia
            $evidencia_fin              = self::cargaImgEvidenciaTermino($request->file('foto_fin'));
            $ticket->EVIDENCIA_TERMINO  = $evidencia_fin;
        }

        $ticket->save();
        return redirect()->route('consultar.ticket.pasado');
    }

// CARGA/BAJA IMAGENES y OBTENCION NOMBRE
    public function cargaImgEvidencia($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_foto =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_evidencias_inicio')->put($nombre_foto,  \File::get($file));

            return $nombre_foto;
        }
    }

    // CARGA/BAJA IMAGENES y OBTENCION NOMBRE
    public function cargaImgEvidenciaTermino($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_foto =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_evidencias_termino')->put($nombre_foto,  \File::get($file));

            return $nombre_foto;
        }
    }

    public function eliminarFotoTicket($nombre_foto){
        if ($nombre_foto != null) {
            // $nombre_foto = '1728068080_1.jpg';
            \Storage::disk('tickets_evidencias_inicio')->delete($nombre_foto);

        }
    }

    public function eliminarFotoTicketActualizado($nombre_foto){
        if ($nombre_foto != null) {
            // $nombre_foto = '1728068080_1.jpg';
            \Storage::disk('tickets_evidencias_termino')->delete($nombre_foto);

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

    public function cargaEvidenciaPago($file){
        if (is_null($file)){
            return null;
        }else{
            //obtenemos el nombre del archivo
            $nombre_archivo =  time()."_".$file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('tickets_evidencias_pago')->put($nombre_archivo,  \File::get($file));

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

    public function eliminarEvidenciaPago($nombre_archivo){
        if ($nombre_archivo != null) {
            \Storage::disk('tickets_evidencias_pago')->delete($nombre_archivo);
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

        if ($data['area'] == 'Finanzas Filiales') {
            $nivel = 'GERENCIA';
        }

        switch ($nivel) {
            case 'GERENCIA':
                // NOTIFICAR GERENTE SI EXISTE
                if ($gerente) {
                    $data['destinatario']  = $gerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($gerente->NOMBRE);

                    $destinatario = $gerente->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }

                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = $subgerente->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }
            break;

            case 'SUBGERENCIA':
                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = $subgerente->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }
            break;

            case 'SUPERVISION':
                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;

                    if ($data['nuevo_ticket']) {
                        Mail::to($destinatario)->send(new GeneracionTicket($data));
                    } elseif ($data['autorizacion_ticket']) {
                        Mail::to($destinatario)->send(new AutorizacionTicket($data));
                    } elseif ($data['anulacion_ticket']){
                        Mail::to($destinatario)->send(new AnulacionTicket($data));
                    }
                }
            break;
        }
    }

    public function envioPrioritarioDirecto($nivel, $area, $data){
        // Enviar correo a encargados
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

                    $destinatario = $gerente->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }

                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = $subgerente->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }
            break;

            case 'SUBGERENCIA':
                // NOTIFICAR SUBGERENTE SI EXISTE
                if ($subgerente) {
                    $data['destinatario'] = $subgerente->NOMBRE;
                    $data['encript']    = Crypt::encryptString($subgerente->NOMBRE);

                    $destinatario = $subgerente->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }

                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }
            break;

            case 'SUPERVISION':
                // NOTIFICAR SUPERVISOR SI EXISTE
                if ($supervisor) {
                    $data['destinatario'] = $supervisor->NOMBRE;
                    $data['encript']    = Crypt::encryptString($supervisor->NOMBRE);

                    $destinatario = $supervisor->CORREO;
                    Mail::to($destinatario)->send(new NotificacionTicketDirecto($data));

                }
            break;
        }

    }

    public function obtenerDestinatarios($ticket){

        $destinatarios = [
            'coordinadores-tel' =>[],
            'coordinadores' =>[],
            'finanzas' =>[],
            'extra' =>[],

        ];


        foreach ($ticket->casa->coordinador_casa as $coordinador) {
            $destinatarios['coordinadores-tel']+= [$coordinador->NOMBRE  => $coordinador->TELEGRAM];
            $destinatarios['coordinadores']    += [$coordinador->NOMBRE  => $coordinador->CORREO];
        }

        foreach ($ticket->casa->encargados_finanzas as $encargado) {
            // CAMBIAR CORREO ESTÁTICO POR DINÁMICO
            $destinatarios['finanzas']         += [$encargado->NOMBRE    => $encargado->CORREO];
        }

        // CONTACTO DE CASA DIRECTO
        if (!empty($ticket->casa->CORREO)) {
            $destinatarios['extra']            += [$ticket->casa->NOMBRE => $ticket->casa->CORREO];
        }

        return $destinatarios;
    }


    public function notificarDestinatariosDirecto($destinatarios, $data){
        // CORREO CORDINADORES
        foreach ($destinatarios['coordinadores'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            $data['supervisor']     = true;
            Mail::to($correo)->send(new NotificacionTicketDirecto($data));
        }
        // TELEGRAM
        $telegram = new TelegramController();
        foreach ($destinatarios['coordinadores-tel'] as $nombre => $telegram) {
            //Notificar TELEGRAM ($destinatario, data)
            $payload = "<b>NUEVO TICKET A GENERADO</b>%0A".
            $ticket->CASA. " - ".$ticket->AREA_RESPONSABLE. " - ".$ticket->AFECCION;

            $telegram->sendText($coordinador->TELEGRAM, $payload);
        }

        // Notificar a destinatarios extra (CASAS SDN SEMAR)
        foreach ($destinatarios['extra'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            $data['supervisor']     = false;
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
        $destinatarios = self::obtenerDestinatarios($ticket);


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
        foreach ($destinatarios['coordinadores'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            $data['coordinador_bdt']     = true;

            Mail::to($correo)->send(new CotizacionTicket($data));
        }

        // SI HUBO COTIZACION
        // Enviar correo a Finanzas Andrés Becerril - Maricarmen Ruiz
        if ($cotizacion) {
            foreach ($destinatarios['finanzas'] as $nombre => $correo) {
                $data['destinatario'] = $nombre;
                $data['coordinador_bdt']   = false;

                Mail::to($correo)->send(new CotizacionTicket($data));
            }
        }
    }

    public function notificarAreasDirecto($nivel, $area_responsable, $area, $data){


        $destinatarios = self::obtenerDestinatarios($data['ticket']);

        if ($area_responsable == 'FYCSA') {
            self::envioPrioritarioDirecto($nivel, $area, $data);
            $area = areas::where('NOMBRE', 'CTBR')->first();
            self::envioPrioritarioDirecto($nivel, $area, $data);

        } else {
            self::envioPrioritarioDirecto($nivel, $area, $data);
        }

        // Enviar correo a supervisores - Destinatario Extra Casa
        self::notificarDestinatariosDirecto($destinatarios, $data);
    }

    public function enviarNuevoTicket($data, $correo_encargado){
        Mail::to($correo_encargado)->send(new GeneracionTicket($data));

    }

    public function enviarCorreoObservaciones($destinatario, $data){
        Mail::to($destinatario)->send(new ObservacionesTicket($data));
    }

    public function enviarCorreoAnulacion($destinatarios, $data){

        if ($data['area']->NOMBRE == 'FYCSA') {
            self::envioPrioritario($data['nivel'], $data['area'], $data);

            $data['area'] = areas::where('NOMBRE', 'CTBR')->first();
            self::envioPrioritario($data['nivel'], $data['area'], $data);

        } else {
            self::envioPrioritario($data['nivel'], $data['area'], $data);
        }


        $data['area'] = $data['area']->NOMBRE;
        foreach ($destinatarios['coordinadores'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            Mail::to($correo)->send(new AnulacionTicket($data));
        }

        // Notificar a destinatarios extra SDN SEMAR
        foreach ($destinatarios['extra'] as $nombre => $correo) {
            $data['destinatario']   = $nombre;
            $data['encript']        = Crypt::encryptString($nombre);
            Mail::to($correo)->send(new AnulacionTicket($data));
        }

    }

    public function enviarCorreoPrueba($destinatario, $data){

        Mail::to($destinatario)->send(new ReporteQuincenalCompleto($data));
        Mail::to($destinatario)->send(new ReporteQuincenalCT($data));
        Mail::to($destinatario)->send(new ReporteQuincenalResumen($data));
    }

// EXPORTACIONES EXCEL
    public function exportCotizacion($nombre_archivo){

        $path = \Storage::disk('tickets_cotizaciones')->path($nombre_archivo);

        return response()->download($path);
    }

    public function exportAutorizacion($nombre_archivo){

        $path = \Storage::disk('tickets_autorizaciones')->path($nombre_archivo);

        return response()->download($path);
    }

    public function exportEvidenciaPago($nombre_archivo){

        $path = \Storage::disk('tickets_evidencias_pago')->path($nombre_archivo);

        return response()->download($path);;
    }
}

