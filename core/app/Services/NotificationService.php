<?php
namespace App\Services;

use App\Events\NotificationCreated;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    private function getAdminIds(): array
    {
        return User::where('status', '1')
                   ->pluck('id')
                   ->toArray();
    }

    public function send(
        string $type,
        string $action,
        string $title,
        string $message,
        string $url = null,
        string $icon = 'notifications'
    ): void {
        foreach ($this->getAdminIds() as $adminId) {
            $notif = Notification::create([
                'user_id' => $adminId,
                'type'    => $type,
                'action'  => $action,
                'title'   => $title,
                'message' => $message,
                'url'     => $url,
                'icon'    => $icon,
            ]);

            broadcast(new NotificationCreated($notif));
        }
    }
}