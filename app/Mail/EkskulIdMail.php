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
    public function __construct($details,$name)
    {
        $this->details = $details;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@ekskul.co.id')
                   ->view('mail/template')
                   ->with(
                    [
                        'nama' => $this->name,
                        'website' => 'www.ekskul.co.id',
                        'id' => base64_encode($this->details),
                        'url' => env('APP_URL'),
                    ]);
    }
}
