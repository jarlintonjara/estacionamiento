<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestParking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $numero, $name, $link)
    {
        $this->user = $user;
        $this->numero = $numero;
        $this->name = $name;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.requestParking')
        ->subject('Solicitud de estacionamiento')->with([
            'user'=> $this->user,
            'numero'=> $this->numero,
            'name'=> $this->name,
            'link'=> $this->link, 
        ]);

    }
}
