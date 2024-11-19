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


// Namespace para fechas
use Carbon\Carbon;


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
        $data_whats = [
            'contenido' => [],
            'ruta' => route('consultar.ticket'),
        ];

        $currentYear = date('Y');
        $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->where([
            ['AREA_RESPONSABLE','<>','SEDENA'],
            ['AREA_RESPONSABLE','<>','SEMAR'],

            ['DAÑO','<>','Siniestro - Desastre Meteorilógico'],
            ['DAÑO','<>','Siniestro - Temblor'],

            ['REINCIDENCIA','<>','SI'],

            ['ESTATUS_AUTORIZACION','<>','SI'],
            ['ESTATUS_AUTORIZACION','<>','ANULADO'],

            ['ESTATUS_COTIZACION','NO'],

            ])->orderBy('FECHA_INICIO', 'ASC')->get();
        // $tickets = tickets::whereYear('FECHA_INICIO', $currentYear)->where([
        //     ['ESTATUS_COTIZACION','NO'],

        //     ])->orderBy('FECHA_INICIO', 'ASC')->get();

        $data_whats['contenido'] = $tickets;

        foreach ($coordinadores as $destinatario) {

            $data_whats['clave'] = $destinatario->NOMBRE;
            self::notificarGeneracionReportes($destinatario->TELEFONO, $data_whats);
        }
    }

    // NOTIFICACIONES
    //WhatsApp
    public function enviar($payload){
        $id_telefono = '373083419225618';
        $token = 'EABvGrmq3yZCoBO070vYK6Vmd9vqKN07zc57HKFE5wZBkI2WzCcAzdUhrIKnDTdvUKkECZAIMCOHmsjFykcepQnptmcVZCTKWiGuZB1HH2t1ZCtIgwRUoZBzImOTTvgTrZBguDBgCZAbrLigqZAH4KLZAWDG5sX7IVFweg77D2rsnXuRC0kIWhUS6DD7hFqWWZBJ4Wpz3igZDZD';

        // Envio del mensaje via Curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v20.0/'. $id_telefono . '/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$payload,

            CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token
                ),
            ));

        $response = curl_exec($curl);

        curl_close($curl);
    }

    public function notificarGeneracionReportes($destinatario_tel, $data_whats){

        $lista = '';
        foreach ($data_whats['contenido'] as $ticket) {
            $lista .= '* ' . $ticket->FOLIO . '%0A';
        }

        $payload = [
            "messaging_product" => 'whatsapp',
            "recipient_type" => 'individual',
            "to" => $destinatario_tel,
            "type" => 'interactive',
            "interactive" => [
                "type" => 'cta_url',

                "header" => [
                    "type" => 'text',
                    "text" => 'Tickets No Cotizados'
                ],

                "body" => [
                    "text" => $lista
                ],

                "footer" => [
                    "text" => $data_whats['clave']
                ],

                "action" => [
                    "name" => 'cta_url',
                    "parameters" => [
                        "display_text" => 'Revisar',
                        "url" => $data_whats['ruta'],
                    ],
                ]
            ]

        ];

        // ajustar al formato de envio
        $payload = json_encode($payload);

        // permitir saltos de linea
        $payload = str_replace('%0A','\n', $payload);

        // Envio del mensaje via Curl
        self::enviar($payload);

    }
}
