<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderSameCategoryNotification extends Notification implements ShouldQueue
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
            'en' =>  [
                'title' => 'There is new order in ' . ($this->paramters['category_name'] ?? ''),
                'order_id' => (string) $this->paramters['order_id'] ?? null
            ],
            'ar' =>  [
                'title' => 'يوجد طلب جديد في ' . ($this->paramters['category_name'] ?? ''),
                'order_id' => (string) $this->paramters['order_id'] ?? null
            ],
        ];
    }

    public function databaseType(): string
    {
        return 'order-same-category';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'order-same-category';
    }
    public function broadcastAs()
    {
        return 'order-same-category';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }
}
