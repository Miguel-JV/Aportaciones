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
        // Commands\RegistrosEjecucion::class,
        // Commands\NotificacionDiaria::class
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

        $schedule->command('eliminarfotos:tickets')
                            // ->daily();
                            ->cron('* * 01 */3 *');


        $schedule->command('ResumenTickets:ReportesXls')
                            // ->daily();
                            ->monthly();


        $schedule->command('ResumenTickets:NoCotizados')
                            ->weeklyOn(4, '9:00');
        $schedule->command('ResumenTickets:NoCotizados')
                            ->weeklyOn(2, '9:00');
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
