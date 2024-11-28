<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderUnCancelNotification extends Notification implements ShouldQueue
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
                'title' => 'Your order have been uncanceled by managers',
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
            'ar' => [
                'title' => 'تم إلغاء الإيقاف طلبكم من قبل الاداره',
                'order_id' => (string)$this->paramters['order_id'] ?? null
            ],
        ];
    }

    public function databaseType(): string
    {
        return 'order-uncanceled';
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }

    public function broadcastType(): string
    {
        return 'order-uncanceled';
    }

    public function broadcastAs()
    {
        return 'order-uncanceled';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
