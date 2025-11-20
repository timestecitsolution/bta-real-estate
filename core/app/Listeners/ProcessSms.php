<?php

namespace App\Listeners;

use App\Events\SmsRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\SMSService;

class ProcessSms
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SmsRequested $event): void
    {
        $sms = $event->sms;

        try {
            $sms->update(['status' => 'pending']);

            SMSService::send($sms->phone_number, $sms->message);

            $sms->update(['status' => 'sent']);

        } catch (\Exception $e) {
            $sms->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            throw $e; 
        }
    }
}
