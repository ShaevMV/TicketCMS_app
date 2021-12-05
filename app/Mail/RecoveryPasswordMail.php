<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoveryPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $urlForRecoveryPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $urlForRecoveryPassword)
    {
        $this->urlForRecoveryPassword = $urlForRecoveryPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->view('emails.recoveryPassword')->with([
            'urlForRecoveryPassword' => $this->urlForRecoveryPassword
        ]);
    }
}
