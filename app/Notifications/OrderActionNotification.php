<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderActionNotification extends Notification
{
    use Queueable;
    protected $order;
    protected $action;
    /**
     * Create a new notification instance.
     * @param $order
     * @param $action
     * @return void
     */
    public function __construct($order, $action)
    {
        $this->order = $order;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->order->user->name.' Ordered '.$this->order->product->name)
                    ->line('Order ID : '. $this->order->external_id)
                    ->line('Quantity : '. $this->order->qty)
                    ->action('Go to Dashboard', url(env('Domain')))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
