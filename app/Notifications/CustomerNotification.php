<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerNotification extends Notification implements ShouldQueue
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
            'en' => array_merge($this->paramters, [
                'title' => 'You have a new customer signed up ' . ($this->paramters['user_name'] ?? ''),
                'user_id' => (string) $this->paramters['user_id'] ?? null
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => '  لديك مستخدم جديد سجل فى المنصه باسم ' . ($this->paramters['user_name'] ?? ''),
                'user_id' => (string) $this->paramters['user_id'] ?? null
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'new-customer';
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'new-customer';
    }
    public function broadcastAs()
    {
        return 'new-customer';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
