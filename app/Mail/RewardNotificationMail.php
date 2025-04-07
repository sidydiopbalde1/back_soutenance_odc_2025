<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RewardNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $reward;
    public $campaign;

    /**
     * Create a new message instance.
     */
    public function __construct($client, $reward, $campagne)
    {
        $this->client = $client;
        $this->reward = $reward;
        $this->campaign = $campagne;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Vous avez reçu une récompense ! 🎉')
            ->view('emails.reward_notification')
            ->with([
                'clientName' => $this->client->nom,
                'rewardName' => $this->reward['name'],
                'campaignName' => $this->campaign['libelle'],
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reward Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reward_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
