<?php

namespace App\Mail;

use App\Set;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Set $set,$user)
    {
        $this->set = $set;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.notify')
                        ->subject("MIU Online Judge")
                        ->with('set',$this->set)
                        ->with('user', $this->user);
    }
}
