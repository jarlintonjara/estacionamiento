<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationParkingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $numero)
    {
        $this->nombre = $nombre;
        $this->numero = $numero;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.confirmationParking')
        ->subject('Confirmación de solicitud')->with([
            'nombre'=> $this->nombre,
            'numero'=> $this->numero
        ]);
    }
}
