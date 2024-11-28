<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancelNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $paramters;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $paramters = [])
    {
        $this->paramters = $paramters;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(): array
    {
        return [
            'en' => [
                'title' => 'Your order have been canceled by managers',
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
            'ar' => [
                'title' => 'تم إيقاف طلبكم من قبل الاداره',
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
        ];
    }

    public function databaseType(): string
    {
        return 'order-canceled';
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }

    public function broadcastType(): string
    {
        return 'order-canceled';
    }

    public function broadcastAs()
    {
        return 'order-canceled';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
