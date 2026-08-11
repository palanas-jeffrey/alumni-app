<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEventEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $messageContent)
    {
        $this->name = $name;
        $this->messageContent = (string) $messageContent; // Ensure it's always a string
    }

    /**
     * Build the email.
     */
    public function build()
    {
        return $this->view('emails.alumni-event-notification')
            ->with([
                'name' => $this->name,
                'messageContent' => $this->messageContent
            ]);
    }
}