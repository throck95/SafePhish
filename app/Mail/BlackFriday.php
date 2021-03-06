<?php

namespace App\Mail;

use App\Models\Mailing_List_User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlackFriday extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $campaign;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailing_List_User $user, $campaign, $company)
    {
        $this->user = $user;
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $variables = array('user'=>$this->user,'campaign'=>$this->campaign);
        return $this->from(getenv('MAIL_USERNAME'),getenv('MAIL_NAME'))
            ->subject('Check out these Black Friday Deals!')
            ->view('emails.phishing.black_friday')->with($variables);
    }
}
