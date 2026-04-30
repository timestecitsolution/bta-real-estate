<?php

namespace App\Observers;

use App\Models\ClientNotice;
use App\Services\NotificationService;

class ClientNoticeObserver
{
    public function __construct(private NotificationService $notif) {}

    public function created(ClientNotice $clientNotice): void
    {
        $client  = $clientNotice->client?->first_name . ' ' . $clientNotice->client?->last_name;
        $subject = $clientNotice->subject?->name ?? 'Notice';

        $this->notif->send(
            type:    'notice',
            action:  'created',
            title:   'নতুন Notice তৈরি হয়েছে',
            message: "{$client} এর জন্য {$subject} notice তৈরি হয়েছে",
            url:     "https://bta-bd.com/admin/client-notice",
            icon:    'notice'
        );
    }

    public function updated(ClientNotice $clientNotice): void
    {
        $client  = $clientNotice->client?->first_name . ' ' . $clientNotice->client?->last_name;
        $subject = $clientNotice->subject?->name ?? 'Notice';

        $this->notif->send(
            type:    'notice',
            action:  'updated',
            title:   'Notice আপডেট হয়েছে',
            message: "{$client} এর {$subject} notice আপডেট হয়েছে",
            url:     "https://bta-bd.com/admin/client-notice",
            icon:    'notice'
        );
    }

    public function deleted(ClientNotice $clientNotice): void
    {
        $client  = $clientNotice->client?->first_name . ' ' . $clientNotice->client?->last_name;
        $subject = $clientNotice->subject?->name ?? 'Notice';

        $this->notif->send(
            type:    'notice',
            action:  'deleted',
            title:   'Notice ডিলিট হয়েছে',
            message: "{$client} এর {$subject} notice ডিলিট করা হয়েছে",
            url:     "https://bta-bd.com/admin/client-notice",
            icon:    'notice'
        );
    }
}
