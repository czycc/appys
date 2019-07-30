<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserBound extends Notification
{
    use Queueable;

    public $user;
    public $bound_id; //申请id

    public function __construct(User $user, $bound_id)
    {
        $this->user = $user;
        $this->bound_id = $bound_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * @param $notifiable
     * @return array
     *
     *
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => '绑定上级申请',
            'body' => $this->user->nickname . ' 申请绑定上级',
            'type' => 'bound_user',
            'type_id' => (int)$this->bound_id,
        ];
    }


}
