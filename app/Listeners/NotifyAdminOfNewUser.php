<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyAdminOfNewUser
{
    use InteractsWithQueue;

    public function handle(UserRegistered $event): void
    {
        $newUser = $event->user;
        $adminEmail = 'admin@binar.co.id'; // Hardcode atau ambil dari config

        Mail::raw("New user registered: {$newUser->name} ({$newUser->email})", function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('New User Notification');
        });

        Log::info("Admin notification sent for user: {$newUser->id}");
    }
}
