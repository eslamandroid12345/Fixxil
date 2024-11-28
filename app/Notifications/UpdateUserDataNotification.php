<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateUserDataNotification extends Notification implements ShouldQueue
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
                'title' => 'The user has changed his data and is awaiting review.',
                'change_id' => (string) $this->paramters['change_id'] ?? null ,
                'type' => (string) $this->paramters['type'] ?? null ,
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => 'قام المستخدم بتغيير بياناته وفي انتظار المراجعه .',
                'change_id' => (string) $this->paramters['change_id'] ?? null ,
                'type' => (string) $this->paramters['type'] ?? null ,
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'change-data';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'change-data';
    }
    public function broadcastAs()
    {
        return 'change-data';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
