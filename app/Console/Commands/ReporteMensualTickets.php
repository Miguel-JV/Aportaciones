<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Modelos
use DB;
use App\coordinadores;
use App\Exports\consultaCompuestaTickets;

// Namespace para fechas
use Carbon\Carbon;

// Notificaciones
use Illuminate\Support\Facades\Mail;
use App\Mail\ReporteMensualMantenimientos;
use App\Http\Controllers\TelegramController;


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
    // Eliminar anteriores reportes XLS
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_General.xlsx');
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_Sedena.xlsx');
        \Storage::disk('tickets_reportes')->delete('Reporte_Mantenimientos_Semar.xlsx');

    // Generar nuevos reportes XLS

        $dateStart = Carbon::now()->startOfYear();
        $dateEnd = Carbon::now();

        $archivo = new consultaCompuestaTickets($dateStart, $dateEnd);
        $telegram = new TelegramController();

        $archivo->storeGeneral();
        $archivo->storeSedena();
        $archivo->storeSemar();

        $reportes = [
            'general' => 'Reporte_Mantenimientos_General.xlsx',
            'sedena' => 'Reporte_Mantenimientos_Sedena.xlsx',
            'semar' => 'Reporte_Mantenimientos_Semar.xlsx',
        ];
    // Obtener coordinadores
        // Prueba Individual
        // $coordinadores = ['1' => coordinadores::find(1)];
        // $coordinadores = coordinadores::whereNotIn('ID_COORDINADOR',[3])->get();
        $coordinadores = coordinadores::all();


        $reportes = [
            'general' => 'Reporte_Mantenimientos_General.xlsx',
            'sedena' => 'Reporte_Mantenimientos_Sedena.xlsx',
            'semar' => 'Reporte_Mantenimientos_Semar.xlsx',
        ];

    // ENVIO Telegram
        foreach ($reportes as $reporte) {
            $ruta = \Storage::disk('tickets_reportes')->path($reporte);

            foreach ($coordinadores as $destinatario) {
                $telegram->sendDocument($destinatario->TELEGRAM, $ruta);
            }
        }

    // ENVIO Correo
        foreach ($coordinadores as $destinatario) {
            // NOTIFICAR CORREOS
            $reportes['destinatario'] = $destinatario->NOMBRE;
            Mail::to($destinatario->CORREO)->send(new ReporteMensualMantenimientos($reportes));
        }

    }

}
