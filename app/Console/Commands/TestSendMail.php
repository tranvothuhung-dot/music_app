<?php

namespace App\Console\Commands;

use App\Mail\NewsletterSubscriptionConfirmation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test send mail to verify configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info("Sending test mail to: {$email}");

        try {
            Mail::to($email)->send(new NewsletterSubscriptionConfirmation($email));
            $this->info('✓ Email sent successfully!');
        } catch (\Exception $e) {
            $this->error('✗ Failed to send email:');
            $this->error($e->getMessage());
            $this->info("\nDebug Info:");
            $this->info("MAIL_MAILER: " . config('mail.default'));
            $this->info("MAIL_HOST: " . config('mail.mailers.smtp.host'));
            $this->info("MAIL_PORT: " . config('mail.mailers.smtp.port'));
            $this->info("MAIL_USERNAME: " . config('mail.mailers.smtp.username'));
            $this->info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        }
    }
}
