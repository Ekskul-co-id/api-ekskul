<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

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


        $transactiostatu = $data['transaction_status'];
        $payment_type = $data['payment_type'];
        $fraudstatus = $data['fraud_status'];

        if($signatur_key !== $mysignatur_key){
            return response()->json([
                'status' => 'error',
                'message' => 'invalid signature',
            ],400);
        }

        return true;
    }
}
