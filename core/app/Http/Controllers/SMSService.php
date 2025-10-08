<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSService extends Controller
{
    public static function send($number, $message)
    {
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
        return $response;
    }
}
