<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\BulkSmsData;
use Illuminate\Support\Facades\Log;
class SMSService
{
    public static function send($number, $message)
    {
        $sms = BulkSmsData::create([
            'phone_number' => $number,
            'message' => $message,
            'status' => 'pending',
        ]);

        Log::channel('smslog')->info("SMS QUEUED", [
            'number' => $number,
            'message' => $message
        ]);

        $url = env('BULKSMSBD_API_URL');
        $apiKey = env('BULKSMSBD_API_KEY');
        $senderId = env('BULKSMSBD_SENDER_ID');

        $data = [
            "api_key"  => $apiKey,
            "senderid" => trim($senderId),
            "number"   => $number,   
            "message"  => $message,
            "type"     => "text",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $sms->update([
            'response' => $response,
            'status'   => str_contains(strtolower($response), 'success') ? 'sent' : 'failed'
        ]);

        Log::channel('smslog')->info("SMS SENT", [
            'number' => $number,
            'message' => $message,
            'response' => $response,
            'status' => $sms->status
        ]);

        return $response;
    }
}
