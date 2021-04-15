<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\PaymentLog;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    use APIResponse;
    
    public function midtransHandler(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
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
        
        $order = Checkout::findOrFail($checkoutId[0]);

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
            $order->update(['status' => 'success']);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // TODO set transaction status on your database to 'failure'
            $order->update(['status' => 'failure']);
        } else if ($transactionStatus == 'pending') {
            // TODO set transaction status on your database to 'pending' / waiting payment
            $order->update(['status' => 'pending']);
        }
        
        PaymentLog::create([
            'status' => $transactionStatus,
            'raw_response' => $request->getContent(),
            'checkout_id' => $checkoutId[0],
            'payment_type' => $paymentType, 
        ]);
       
        return response()->json([
            'status' => $transactionStatus
        ], 201);
    }
}
