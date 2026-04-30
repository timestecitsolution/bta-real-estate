<?php

namespace App\Observers;

use App\Models\CentralApplication;
use App\Services\NotificationService;

class CentralApplicationObserver
{
    public function __construct(private NotificationService $notif) {}

    public function created(CentralApplication $centralApplication): void
    {
        $user   = $centralApplication->creator?->first_name . ' ' . $centralApplication->creator?->last_name;
        $subject = $centralApplication->subject?->name ?? 'Application';

        $this->notif->send(
            type:    'application',
            action:  'created',
            title:   'নতুন Application সাবমিট হয়েছে',
            message: "{$user} একটি {$subject} application সাবমিট করেছে",
            url:     "https://bta-bd.com/admin/application-list",
            icon:    'application'
        );
    }

    public function deleted(CentralApplication $centralApplication): void
    {
        $user   = $centralApplication->creator?->first_name . ' ' . $centralApplication->creator?->last_name;
        $subject = $centralApplication->subject?->name ?? 'Application';

        $this->notif->send(
            type:    'application',
            action:  'deleted',
            title:   'Application ডিলিট হয়েছে',
            message: "{$user} এর {$subject} application ডিলিট করা হয়েছে",
            url:     "https://bta-bd.com/admin/application-list",
            icon:    'application'
        );
    }

    public function restored(CentralApplication $centralApplication): void
    {
        $user   = $centralApplication->creator?->first_name . ' ' . $centralApplication->creator?->last_name;

        $this->notif->send(
            type:    'application',
            action:  'restored',
            title:   'Application পুনরুদ্ধার হয়েছে',
            message: "{$user} এর application পুনরুদ্ধার করা হয়েছে",
            url:     "https://bta-bd.com/admin/application-list",
            icon:    'application'
        );
    }

    public function forceDeleted(CentralApplication $centralApplication): void
    {
        $user   = $centralApplication->creator?->first_name . ' ' . $centralApplication->creator?->last_name;

        $this->notif->send(
            type:    'application',
            action:  'force_deleted',
            title:   'Application স্থায়ীভাবে ডিলিট হয়েছে',
            message: "{$user} এর application স্থায়ীভাবে মুছে ফেলা হয়েছে",
            url:     "https://bta-bd.com/admin/application-list",
            icon:    'application'
        );
    }
}
