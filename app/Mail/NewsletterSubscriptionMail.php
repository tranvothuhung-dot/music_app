<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Chào mừng đến với MusicApp Newsletter')
            ->view('emails.newsletter-subscription');
    }
}
