<?php

namespace App\Listeners;

use App\Events\OrderActionEvent;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderActionListener
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
     * @param  OrderActionEvent  $event
     * @return void
     */
    public function handle(OrderActionEvent $event)
    {
        $order = $event->getOrder();
        switch ($event->getAction()){
            case 'created' :
                $text = __('User :user ordered :product', [
                    'user' => $order->user->name,
                    'product' => $order->product->name,
                ]);
                break;
            case 'updated':
                $text =  __('User :user changed order product to :product', [
                    'user' => $order->user->name,
                    'product' => $order->product->name,
                ]);
                break;
            default:
                break;
        }
        activity("order")
            ->performedOn($order)
            ->withProperties(['action' => $event->getAction()])
            ->log($text);
    }
}
