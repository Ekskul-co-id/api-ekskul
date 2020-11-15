<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Payment_logs;

class WebhooksController extends Controller
{
    public function midtransHandler(Request $request)
    {
        $request = $request->getContent();
        
        $data = json_decode($request,true);
        // dd($recode);

        $signatur_key = $data['signature_key'];


        $orderid = $data['order_id'];
        $statuscode = $data['status_code'];
        $grossamount = $data['gross_amount'];
        $serverkey = env('MIDTRANS_SERVER_KEY');

        $mysignatur_key = hash('sha512',$orderid.$statuscode.$grossamount.$serverkey);


        $transactionStatus = $data['transaction_status'];
        $payment_type = $data['payment_type'];
        $fraudStatus = $data['fraud_status'];

        if($signatur_key !== $mysignatur_key){
            return response()->json([
                'status' => false,
                'message' => 'invalid signature',
            ],400);
        }

        $realorerid = explode('-',$orderid);
        $order = Checkout::where('id_checkout','=',$realorerid[0])->first();
        if(!$order){
            return response()->json([
                'status' => 'error',
                'message' => 'order id not found !',
            ],404);
        }

        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'challenge'){
                // TODO set transaction status on your database to 'challenge'
                Checkout::where('id_checkout','=',$realorerid)->update(['status' => 'challenge']);
                $history = [
                    'status' => $transactionStatus,
                    'raw_response' => json_encode($data),
                    'id_checkout' => $realorerid[0],
                    'payment_type' => $payment_type, 
                ];
                Payment_logs::create($history);
                return response()->json([
                    'status' => 'chalangge',
                ],200);

            } else if ($fraudStatus == 'accept'){
                // TODO set transaction status on your database to 'success'
                Checkout::where('id_checkout','=',$realorerid)->update(['status' => 'success']);
                $history = [
                    'status' => $transactionStatus,
                    'raw_response' => json_encode($data),
                    'id_checkout' => $realorerid[0],
                    'payment_type' => $payment_type, 
                ];
                Payment_logs::create($history);
                return response()->json([
                    'status' => 'success',
                ],200);
            }
        } else if ($transactionStatus == 'settlement'){
            // TODO set transaction status on your database to 'success'
            Checkout::where('id_checkout','=',$realorerid)->update(['status' => 'success']);
            $history = [
                'status' => $transactionStatus,
                'raw_response' => json_encode($data),
                'id_checkout' => $realorerid[0],
                'payment_type' => $payment_type, 
            ];
            Payment_logs::create($history);
            return response()->json([
                'status' => 'success',
            ],200);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire'){
          // TODO set transaction status on your database to 'failure'
          Checkout::where('id_checkout','=',$realorerid)->update(['status' => 'failure']);
          $history = [
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'id_checkout' => $realorerid[0],
            'payment_type' => $payment_type, 
        ];
        Payment_logs::create($history);
        return response()->json([
            'status' => 'failure',
        ],200);
        } else if ($transactionStatus == 'pending'){
          // TODO set transaction status on your database to 'pending' / waiting payment
          Checkout::where('id_checkout','=',$realorerid)->update(['status' => 'pending']);
          $history = [
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'id_checkout' => $realorerid[0],
            'payment_type' => $payment_type, 
        ];
        Payment_logs::create($history);
        return response()->json([
            'status' => 'pending',
        ],200);
        }

    }
}
