<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Notification;
use App\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Buat notifikasi baru di database
        Notification::create([
            'message' => $event->user->name . ' telah mendaftar di PerPusWeb.',
            'type' => 'new_registration',
        ]);
    }
}
