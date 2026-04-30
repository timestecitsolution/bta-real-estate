<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class NotificationCreated
{
    use SerializesModels;

    public function __construct(public Notification $notification) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('notifications.' . $this->notification->user_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id'      => $this->notification->id,
            'type'    => $this->notification->type,
            'action'  => $this->notification->action,
            'title'   => $this->notification->title,
            'message' => $this->notification->message,
            'url'     => $this->notification->url,
            'icon'    => $this->notification->icon,
            'time'    => $this->notification->created_at->diffForHumans(),
        ];
    }
}
