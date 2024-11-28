<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteCommentNotification extends Notification implements ShouldQueue
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
                'title' => 'Your comment has been deleted for violating the platform rules. If you repeat it, you will be banned.',
                'blog_id' => (string) $this->paramters['blog_id'] ?? null,
                'is_blog' => (string) $this->paramters['is_blog'] ?? null,
            ]),
            'ar' => array_merge($this->paramters, [
                'title' => 'تم حذف تعليقك لمخالفه قواعد المنصه وفى حاله التكرار سيتم حظرك',
                'blog_id' => (string) $this->paramters['blog_id'] ?? null,
                'is_blog' => (string) $this->paramters['is_blog'] ?? null,
            ]),
        ];
    }

    public function databaseType(): string
    {
        return 'delete-comment';
    }

    public function toBroadcast(): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase());
    }
    public function broadcastType(): string
    {
        return 'delete-comment';
    }
    public function broadcastAs()
    {
        return 'delete-comment';
    }

    public function firebaseData()
    {
        return array_merge($this->toDatabase(), ['type' => $this->databaseType()]) ?? [];
    }

}
