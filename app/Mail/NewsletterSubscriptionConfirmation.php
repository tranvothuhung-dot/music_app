<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Xác nhận đăng ký nhận tin từ MusicApp')
            ->view('emails.newsletter-subscription')
            ->with(['email' => $this->email]);
    }
}
