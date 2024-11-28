<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestOrderNotification extends Notification implements ShouldQueue
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
                'title' => 'You have a new order from ' . ($this->paramters['user_name'] ?? ''),
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
            'ar' => [
                'title' => 'لديك طلب جديد من ' . ($this->paramters['user_name'] ?? ''),
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
        ];
    }

    public function databaseType(): string
    {
        return 'new-order';
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }

    public function broadcastType(): string
    {
        return 'new-order';
    }

    public function broadcastAs()
    {
        return 'new-order';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }
}
