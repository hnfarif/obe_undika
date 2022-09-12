<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DosenPenyusun extends Mailable
{
    use Queueable, SerializesModels;

    private $rps;
    private $dosen;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rps, $dosen)
    {
        $this->rps = $rps;
        $this->dosen = $dosen;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Menyusun Rps pada aplikasi OBE')->markdown('emails.dosen.penyusun', [
            'rps' => $this->rps,
            'dosen' => $this->dosen

        ]);
    }
}
