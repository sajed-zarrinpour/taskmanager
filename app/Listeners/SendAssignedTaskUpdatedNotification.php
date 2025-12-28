<?php

namespace App\Listeners;

use App\Events\AssignedTaskUpdatedEvent;
use App\Notifications\AssignedTaskUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendAssignedTaskUpdatedNotification 
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssignedTaskUpdatedEvent $event): void
    {
        Notification::send($event->user, new AssignedTaskUpdatedNotification($event->task));
    }
}
