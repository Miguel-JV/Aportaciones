<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReporteMensualMantenimientos extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $general = \Storage::disk('tickets_reportes')->path($this->data['general']);
        $sedena = \Storage::disk('tickets_reportes')->path($this->data['sedena']);
        $semar = \Storage::disk('tickets_reportes')->path($this->data['semar']);

        return $this->view('correos.reporteMantenimientos')
        ->with('data', $this->data)
        ->subject('Nuevo Reporte de Mantenimientos')
        ->attach($general)
        ->attach($sedena)
        ->attach($semar);
    }
}
