<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReceived extends Notification
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $store = $this->order->store;

        $message = (new MailMessage)
            ->subject("Your {$store->name} order, {$this->order->number}")
            ->greeting("Thank you, {$this->order->customer_name}.")
            ->line('Your order is in. We will email again when it ships.');

        $this->order->items->each(fn (OrderItem $item) => $message->line(
            "{$item->quantity} × {$item->name}".($item->variant ? " ({$item->variant})" : '').' — '.$store->formatMoney($item->line_total),
        ));

        return $message
            ->line('Shipping: '.($this->order->shipping === 0 ? 'free' : $store->formatMoney($this->order->shipping)))
            ->line('**Total, paid on delivery: '.$store->formatMoney($this->order->total).'**')
            ->line("Delivering to {$this->order->address}, {$this->order->city}.")
            ->replyTo($store->email, $store->name)
            ->salutation($store->name);
    }
}
