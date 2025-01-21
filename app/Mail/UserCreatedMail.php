<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public $subject;
    /**
     * Crée une nouvelle instance de message.
     */
    public function __construct(User $user,$subject)
    {
        $this->user = $user;
        $this->subject = $subject;
    }

    /**
     * Construit le message.
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view('emails.user-created') 
            ->with([
                'user' => $this->user,
                'defaultPassword' => $this->user->password,
                'loginUrl' => url('/change-password'), 
            ]);
    }
}

