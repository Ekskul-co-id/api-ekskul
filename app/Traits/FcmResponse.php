<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait FcmResponse
{
    public function fcm($deviceToken, $title, $image, $body)
    {
        $url = env('FCM_SENDER_URL');
        
        $serverKey = env('FCM_SERVER_KEY');
        
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key='.$serverKey
        ];
        
        $data = [
            'registration_ids' => $deviceToken,
            'priority' => 'high',
            'soundName' => 'default',
            'notification' => [
                'title' => $title,
                'image' => $image,
                'body' => $body
            ]
        ];
        
        $response = Http::withHeaders($headers)->post($url, $data);
        
        return $response->json();
    }
}