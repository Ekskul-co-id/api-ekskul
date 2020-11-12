<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class EkskulIdMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@ekskul.co.id')
                   ->view('mail/template')
                   ->with(
                    [
                        'nama' => 'Admin Eksuk.co.id',
                        'website' => 'www.ekskul.co.id',
                        'id' => base64_encode($this->details),
                        'url' => env('APP_URL'),
                    ]);
    }
}
