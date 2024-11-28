<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncreasePointNotification extends Notification implements ShouldQueue
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
                'title' => 'You add points from admin count'. $this->paramters['amount']. __('messages.For'). $this->paramters['reason'],
                'user_id' => (string) $this->paramters['user_id'] ?? null
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => 'تم اضافة نقاط جديدة من قبل المنصة عدد '. $this->paramters['amount']. __('messages.For'). $this->paramters['reason'],
                'user_id' => (string) $this->paramters['user_id'] ?? null
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'increase-point';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'increase-point';
    }
    public function broadcastAs()
    {
        return 'increase-point';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
