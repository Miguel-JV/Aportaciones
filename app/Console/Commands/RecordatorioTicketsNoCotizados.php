<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Modelos
use DB;

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


// Notificaciones
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioTicketNoCotizado;
use App\Http\Controllers\TelegramController;



class RecordatorioTicketsNoCotizados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ResumenTickets:NoCotizados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio del acumulado de los tickets no cotizados tras su generacion.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $coordinadores = coordinadores::all();
        $lista = '';
        $data_telegram =[
            'lista' => '',
            'total' => '',
        ];
        $data_correo = [
            'casa' => '',
            'area' => '',
            'lista' => '',

            'destinatario' => '',
        ];

        $currentYear = date('Y');
        $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->where([
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

            ])->orderBy('FECHA_INICIO', 'ASC')->get();

        foreach ($tickets as $ticket) {
            $lista .= '-- ' . $ticket->FOLIO.' - '.$ticket->CASA.' - '.$ticket->AREA_RESPONSABLE.
            '%0A';
        }

        $data_telegram['lista'] = $lista;
        $data_telegram['total'] = $tickets->count();


    // Notificar Telegram
        foreach ($coordinadores as $destinatario) {
            self::notificarGeneracionReportes($destinatario->TELEGRAM, $data_telegram);
        }

    // Notificar Correo
        foreach ($tickets as $ticket) {

            $data_correo = [
                'casa'      => $ticket->CASA,
                'area'      => $ticket->CASA,

                'folio'     => $ticket->FOLIO,

                'fecha'     => $ticket->FECHA_INICIO,
                'prioridad' => $ticket->PRIORIDAD,
                'daño'      => $ticket->DAÑO,
                'afeccion'  => $ticket->AFECCION,

                'ticket'    => $ticket,
            ];
            $nivel = $ticket->NIVEL;
            $area  = areas::where('NOMBRE', $ticket->AREA_RESPONSABLE)->first();

            self::envioPrioritarioRecordatorio($nivel,$area, $data_correo);
        }


    }

    // NOTIFICACIONES
    //Telegram
    public function notificarGeneracionReportes($chat_id, $data_telegram){
        $telegram = new TelegramController();

        $payload = "<b>TICKETS NO COTIZADOS</b>%0A".
        "%0A<blockquote expandable><b><i>Cantidad: ".$data_telegram['total']."</i></b> %0A".$data_telegram['lista']."</blockquote>";

        $telegram->sendText($chat_id, $payload);
    }

    // CORRECION
    
    // Correo
    // public function envioPrioritarioRecordatorio($nivel, $area, $data){

    //     // Enviar correo a encargados
    //     // $area    = $ticket->afeccion->area_afeccion;
    //     $data['area'] = $area->NOMBRE;

    //     $supervisor = $data['ticket']->casa->supervisor_casa->where('ID_AREA', $area->ID_AREA)->first();
    //     $subgerente = $data['ticket']->casa->subgerente_casa->where('ID_AREA', $area->ID_AREA)->first();
    //     $gerente    = $data['ticket']->casa->gerente_casa->where('ID_AREA', $area->ID_AREA)->first();

    //     switch ($nivel) {
    //         case 'GERENCIA':
    //             // NOTIFICAR GERENTE SI EXISTE
    //             if ($gerente) {
    //                 $data['destinatario']  = $gerente->NOMBRE;
    //                 $destinatario = $gerente->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }

    //             // NOTIFICAR SUBGERENTE SI EXISTE
    //             if ($subgerente) {
    //                 $data['destinatario'] = $subgerente->NOMBRE;
    //                 $destinatario = $subgerente->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }

    //             // NOTIFICAR SUPERVISOR SI EXISTE
    //             if ($supervisor) {
    //                 $data['destinatario'] = $supervisor->NOMBRE;
    //                 $destinatario = $supervisor->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }
    //         break;

    //         case 'SUBGERENCIA':
    //             // NOTIFICAR SUBGERENTE SI EXISTE
    //             if ($subgerente) {
    //                 $data['destinatario'] = $subgerente->NOMBRE;
    //                 $destinatario = $subgerente->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }

    //             // NOTIFICAR SUPERVISOR SI EXISTE
    //             if ($supervisor) {
    //                 $data['destinatario'] = $supervisor->NOMBRE;
    //                 $destinatario = $supervisor->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }
    //         break;

    //         case 'SUPERVISION':
    //             // NOTIFICAR SUPERVISOR SI EXISTE
    //             if ($supervisor) {
    //                 $data['destinatario'] = $supervisor->NOMBRE;
    //                 $destinatario = $supervisor->CORREO;

    //                 Mail::to($destinatario)->send(new RecordatorioTicketNoCotizado($data));
    //             }
    //         break;
    //     }
    // }

}
