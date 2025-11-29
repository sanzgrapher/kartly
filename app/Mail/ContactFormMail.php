<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'New contact message from ' . ($this->data['name'] ?? 'Website');

        return $this->subject($subject)
            ->replyTo($this->data['email'] ?? null)
            ->view('emails.contact')
            ->with(['data' => $this->data]);
    }
}
