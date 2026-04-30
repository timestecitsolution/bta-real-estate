<?php

namespace App\Observers;

use App\Models\Contact;
use App\Services\NotificationService;

class ContactObserver
{
    public function __construct(private NotificationService $notif) {}

    public function created(Contact $contact): void
    {
        // first_name + last_name দিয়ে
        $name = $contact->first_name . ' ' . $contact->last_name;

        $this->notif->send(
            type:    'contact',
            action:  'created',
            title:   'নতুন Contact যোগ হয়েছে',
            message: "{$name} contact এ যোগ হয়েছে",
            url:     "https://bta-bd.com/admin/contacts",
            icon:    'contacts'
        );
    }

    public function updated(Contact $contact): void
    {
        $name = $contact->first_name . ' ' . $contact->last_name;

        $this->notif->send(
            type:    'contact',
            action:  'updated',
            title:   'Contact আপডেট হয়েছে',
            message: "{$name} এর তথ্য আপডেট হয়েছে",
            url:     "https://bta-bd.com/admin/contacts",
            icon:    'contacts'
        );
    }

    public function deleted(Contact $contact): void
    {
        $name = $contact->first_name . ' ' . $contact->last_name;

        $this->notif->send(
            type:    'contact',
            action:  'deleted',
            title:   'Contact ডিলিট হয়েছে',
            message: "{$name} ডিলিট করা হয়েছে",
            url:     "https://bta-bd.com/admin/contacts",
            icon:    'contacts'
        );
    }
}