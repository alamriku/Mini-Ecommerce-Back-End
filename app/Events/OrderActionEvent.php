<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderActionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $order;
    protected $action;
    /**
     * Create a new event instance.
     * @param Order $order
     * @param $action
     * @return void
     */
    public function __construct(Order $order, $action)
    {
        $this->order = $order;
        $this->action = $action;
    }
    public function getOrder()
    {
        return $this->order;
    }
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
