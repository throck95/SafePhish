<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUser extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $changes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, array $changes)
    {
        $this->user = $user;
        $this->changes = $changes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $variables = array('user'=>$this->user,'changes'=>$this->changes);
        return $this->from(getenv('MAIL_USERNAME'),getenv('MAIL_NAME'))
            ->subject('SafePhish Account Activity')
            ->view('emails.updateUser')->with($variables);
    }
}
