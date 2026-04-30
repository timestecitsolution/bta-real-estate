<?php

namespace App\Observers;

use App\Models\EmiPayment;
use App\Services\NotificationService;

class EmiPaymentObserver
{
    public function __construct(private NotificationService $notif) {}

    public function created(EmiPayment $emi): void
    {
        $booking    = $emi->booking;
        $client     = $booking?->client;
        $clientName = $client
            ? $client->first_name . ' ' . $client->last_name
            : 'Unknown Client';

        $amount = number_format($emi->total_amount, 2);

        $this->notif->send(
            type:    'emi',
            action:  'created',
            title:   'নতুন EMI Payment জমা হয়েছে',
            message: "{$clientName} — ৳{$amount} EMI payment দিয়েছে",
            url:     "https://bta-bd.com/login-new",
            icon:    'payments'
        );
    }
}
