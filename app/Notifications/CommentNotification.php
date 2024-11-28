<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification implements ShouldQueue
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
                'title' => 'You have a new comment from ' . ($this->paramters['user_name'] ?? ''),
                'blog_id' => (string) $this->paramters['blog_id'] ?? null,
                'is_blog' => (string) $this->paramters['is_blog'] ?? null,

            ],
            'ar' => [
                'title' => 'لديك تعليق جديد من ' . ($this->paramters['user_name'] ?? ''),
                'blog_id' => (string) $this->paramters['blog_id'] ?? null,
                'is_blog' => (string) $this->paramters['is_blog'] ?? null,
            ],
        ];
    }

    public function databaseType(): string
    {
        return 'new-comment';
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }

    public function broadcastType(): string
    {
        return 'new-comment';
    }

    public function broadcastAs()
    {
        return 'new-comment';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
