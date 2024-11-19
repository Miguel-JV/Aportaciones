<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Modelos
use DB;
use App\coordinadores;
use App\Exports\consultaCompuestaTickets;

// Namespace para fechas
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReporteMensualMantenimientos;

class ReporteMensualTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ResumenTickets:ReportesXls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de mails de los resumenes de los acumulados de mantenimientos mensuales.';

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
        // Eliminar anteriores reportes
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_General.xlsx');
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_Sedena.xlsx');
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_Semar.xlsx');


        $dateStart = Carbon::now()->startOfYear();
        $dateEnd = Carbon::now();


        $archivo = new consultaCompuestaTickets($dateStart, $dateEnd);
        $archivo->storeGeneral();
        $archivo->storeSedena();
        $archivo->storeSemar();

        $coordinadores = coordinadores::all();
        $data = [
            'general' => 'Reporte_Mantenimientos_General.xlsx',
            'sedena' => 'Reporte_Mantenimientos_Sedena.xlsx',
            'semar' => 'Reporte_Mantenimientos_Semar.xlsx',
            'destinatario' =>'',
        ];
        $data_whats = [
            'contenido' => [
                'Reporte General', 'Reporte Sedena', 'Reporte Semar',
            ],
            'ruta' => 'https://mail.google.com/mail/u/0/#inbox',
        ];

        foreach ($coordinadores as $destinatario) {
            $data['destinatario'] = $destinatario->NOMBRE;
            self::reporteMensual($destinatario->CORREO, $data);

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
        foreach ($data_whats['contenido'] as $reporte) {
            $lista .= '* ' . $reporte . '%0A';
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
                    "text" => 'REPORTES DE MANTENIMIENTOS GENERADOS'
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
                        "url" => $data_whats['ruta']
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

    //Mail
    public function reporteMensual($destinatario_mail, $data_mail){

        Mail::to($destinatario_mail)->send(new ReporteMensualMantenimientos($data_mail));
    }

}
