<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwoFactorCode extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $variables = array('user'=>$this->user,'securityCode'=>$this->code);
        return $this->from(getenv('MAIL_USERNAME'),getenv('MAIL_NAME'))
            ->subject('Your SafePhish Verification Code')
            ->view('emails.2fa')->with($variables);
    }
}
