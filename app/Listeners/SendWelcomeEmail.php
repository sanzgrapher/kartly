<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Mail\Contracts\MailServiceInterface;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;
    protected $mailService;

    /**
     * Create the event listener.
     */
    public function __construct(MailServiceInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $this->mailService->sendWelcomeEmail($event->user);
    }
}
