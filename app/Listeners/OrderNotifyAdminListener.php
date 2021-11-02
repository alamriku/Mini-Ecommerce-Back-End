<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\OrderActionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderNotifyAdminListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $order = $event->getOrder();
        $action = $event->getAction();
        $admin = User::where('is_admin',1)->first();
        $admin->notify(new OrderActionNotification($order, $action));
    }
}
