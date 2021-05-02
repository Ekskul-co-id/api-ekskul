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
        
        if(empty($data)){
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

        if($signaturKey !== $mySignaturKey){
            return $this->response("Invalid signature.", null, 422);
        }

        $checkoutId = explode('-', $orderId);
        
        $order = Checkout::find($checkoutId[0]);
        
        if (empty($order)) {
            return $this->response("Order not found.", null, 404);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                // TODO set transaction status on your database to 'challenge'
                $order->update(['status' => 'challenge']);
            } else if ($fraudStatus == 'accept') {
                // TODO set transaction status on your database to 'success'
                $order->update(['status' => 'success']);
            }
        } else if ($transactionStatus == 'settlement') {
            // TODO set transaction status on your database to 'success'
            $body = "Transaksi sukses";
            
            $order->update(['status' => 'success']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // TODO set transaction status on your database to 'failure'
            $body = "Transaksi gagal";
            
            $order->update(['status' => 'failure']);
        } else if ($transactionStatus == 'pending') {
            // TODO set transaction status on your database to 'pending' / waiting payment
            $body = "Transaksi pending";
            
            $order->update(['status' => 'pending']);
        }
        
        $url = env('FCM_SENDER_URL');
        
        $server_key = env('FCM_SERVER_KEY');
        
        $headers = [
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        ];
        
        $data = [
            'to' => $order->user->device_token,
            'priority' => 'high',
            'soundName' => 'default',
            'notification' => [
                'title' => $transactionStatus,
                'image' => $order->playlist->image,
                'body' => $body
            ]
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key='.$server_key
        ])->post($url, $data);
        
        PaymentLog::create([
            'status' => $transactionStatus,
            'raw_response' => $request->getContent(),
            'checkout_id' => $checkoutId[0],
            'payment_type' => $paymentType, 
        ]);
       
        return response()->json([
            'status' => $transactionStatus,
            'data' => $response->json()
        ], 201);
    }
}
