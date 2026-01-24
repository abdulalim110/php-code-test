<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        Mail::raw("Hi {$user->name}, Welcome to Binar App!", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Welcome Aboard!');
        });
        
        Log::info("Welcome email sent to {$user->email}");
    }
}
