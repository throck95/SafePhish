<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminForcedPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $variables = array('user'=>$this->user,'password'=>$this->password);
        return $this->from(getenv('MAIL_USERNAME'),getenv('MAIL_NAME'))
            ->subject('SafePhish Password Reset')
            ->view('emails.resetPassword')->with($variables);
    }
}
