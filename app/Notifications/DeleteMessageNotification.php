<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteMessageNotification extends Notification implements ShouldQueue
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
                'title' => 'Your message has been deleted for violating the platform rules. If you repeat it, you will be banned.',
                'order_id' => (string) $this->paramters['order_id'] ?? null
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => 'تم حذف رسالتك لمخالفه قواعد المنصه وفى حاله التكرار سيتم حظرك',
                'order_id' => (string) $this->paramters['order_id'] ?? null
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'delete-message';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'delete-message';
    }
    public function broadcastAs()
    {
        return 'delete-message';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
