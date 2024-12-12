<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Modelos
use App\tickets;

// Namespace para fechas
use Carbon\Carbon;

class EliminarFotosTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eliminarfotos:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecucion periodica de la eliminacion de las fotos para evidencias de mantenimientos de tickets.';

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
        // fechas de inicio para
        $dateStart = Carbon::now()->startOfMonth()->subMonth(3);
        // $dateEnd = Carbon::now()->startOfMonth();
        $dateEnd = Carbon::now();

        $tickets = tickets::whereBetween('FECHA_INICIO', [$dateStart,$dateEnd])->get();

        foreach ($tickets as $ticket ) {
            self::eliminarFotoTicket($ticket['FOTO_2']);
            self::eliminarFotoTicket($ticket['FOTO_3']);
        }
    }
// CONTROL DE REGISTROS ANUALES
    public function eliminarFotoTicket($nombre_foto){
        if ($nombre_foto != null) {
            // $nombre_foto = '1728068080_1.jpg';
            \Storage::disk('tickets_evidencias_inicio')->delete($nombre_foto);
        }
    }
}
