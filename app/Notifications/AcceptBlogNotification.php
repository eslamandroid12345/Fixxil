<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptBlogNotification extends Notification implements ShouldQueue
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
                'title' => 'Your article is published',
                'blog_id' => (string) $this->paramters['blog_id'] ?? null
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => 'تم الموافقة على المقال الخاص بك وتم النشر',
                'blog_id' => (string) $this->paramters['blog_id'] ?? null
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'accept-blog';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'accept-blog';
    }
    public function broadcastAs()
    {
        return 'accept-blog';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
