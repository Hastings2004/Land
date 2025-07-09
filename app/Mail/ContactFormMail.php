<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    /**
     * Create a new message instance.
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Contact Form Submission - ATSOGO Land Marketing')
                    ->view('emails.contact-form')
                    ->with([
                        'name' => $this->contactData['name'],
                        'email' => $this->contactData['email'],
                        'message' => $this->contactData['message'],
                    ]);
    }
} 