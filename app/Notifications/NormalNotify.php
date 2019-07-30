<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NormalNotify extends Notification
{
    use Queueable;

    public $title;
    public $body;
    public $type;
    public $type_id;

    public function __construct($title, $body, $type, $type_id = 0)
    {
        $this->title = $title;
        $this->body = $body;
        $this->type = $type;
        $this->type_id = $type_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type_id' => (int)$this->type_id,
            'type' => $this->type
        ];
    }
}
