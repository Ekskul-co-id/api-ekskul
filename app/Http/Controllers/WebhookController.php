<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\PaymentLog;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    use APIResponse;
    
    public function midtransHandler(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        if (empty($data)) {
            return $this->response("Invalid data.", null, 422);
        }
        
        $signaturKey = $data['signature_key'];
        
        $orderId = $data['order_id'];
        
        $statusCode = $data['status_code'];
        
        $grossAmount = $data['gross_amount'];
        
        $serverKey = env('MIDTRANS_SERVER_KEY');

        $mySignaturKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $transactionStatus = $data['transaction_status'];
        
        $paymentType = $data['payment_type'];
        
        $fraudStatus = $data['fraud_status'];

        if ($signaturKey !== $mySignaturKey) {
            return $this->response("Invalid signature.", null, 422);
        }

        $checkoutId = explode('-', $orderId);
        
        $order = Checkout::with('user', 'course')->find($checkoutId[0]);
        
        if (empty($order)) {
            return $this->response("Order not found.", null, 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->update(['status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                $order->update(['status' => 'success']);
            }
        } else if ($transactionStatus == 'settlement') {
            $title = "Transaksi berhasil!";
            
            $body = "Berhasil membeli course ".$order->course->name.".";
            
            $order->update(['status' => 'success']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            if ($transactionStatus == 'cancel') {
                $title = "Pembayaran dibatalkan!";
            
                $body = "Pembayaran ".$order->course->name." dibatalkan.";
            } else if ($transactionStatus == 'deny') {
                $title = "Pembayaran ditolak!";
            
                $body = "Pembayaran ".$order->course->name." ditolak.";
            } else if ($transactionStatus == 'expire') {
                $title = "Pembayaran berkahir!";
            
                $body = "Waktu pembayaran course ".$order->course->name." telah berkahir.";
            }
            
            $order->update(['status' => 'failure']);
        } else if ($transactionStatus == 'pending') {
            $body = "Transaksi pending";
            
            $order->update(['status' => 'pending']);
        }
        
        $url = env('FCM_SENDER_URL');
        
        $serverKey = env('FCM_SERVER_KEY');
        
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key='.$serverKey
        ];
        
        if (!empty($title) && !empty($body)) {
            $data = [
                'to' => $order->user->device_token,
                'priority' => 'high',
                'soundName' => 'default',
                'notification' => [
                    'title' => $title,
                    'image' => $order->course->image,
                    'body' => $body
                ]
            ];
            
            $response = Http::withHeaders($headers)->post($url, $data);
        }else{
            $response = null;
        }
        
        $result = $response ? $response->json() : '';
        
        PaymentLog::create([
            'status' => $transactionStatus,
            'checkout_id' => $checkoutId[0],
            'payment_type' => $paymentType,
            'raw_response' => $request->getContent(),
            'fcm_response' => json_encode($result)
        ]);
        
        return response()->json([
            'status' => $transactionStatus,
            'data' => $result
        ], 201);
    }
}
