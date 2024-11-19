<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\RegistrosEjecucion::class,
        Commands\NotificacionDiaria::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('registros:txt')
        //         ->everyMinute();

        // $schedule->command('whatsapp:incidencias')
        //         ->everyMinute();

        // $schedule->command('resumen:tutorias')
        //         ->everyMinute();



// TICKETS
        // $schedule->command('eliminarfotos:tickets')
        //             ->cron('* * 01 */3 *');


        // $schedule->command('eliminarfotos:tickets')
        //                 ->everyMinute();


        // $schedule->command('ResumenTickets:ReportesXls')
        //                     ->everyMinute();
                        // ->monthly();

        $schedule->command('ResumenTickets:NoCotizados')
                            ->everyMinute();
        //                 ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
