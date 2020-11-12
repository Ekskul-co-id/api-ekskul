<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Checkout;

class OrderController extends Controller
{
    private function getMidtransUrl($params)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('IS_PRODUCTION');
        \Midtrans\Config::$is3ds = (bool) env('IS_3DS');


        $snapurl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return $snapurl;
    }

    public function createOrder(Request $request)
    {
        $itemDetails = [
            [
                'id' => rand(),
                'price' => 10000,
                'quantity' => 2,
                'name' => 'Course Online',
                'category' => 'Programin',
                'brand' => 'ekskulid'
            ]
        ];
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'item_details' => $itemDetails, 
            'customer_details' => array(
                'first_name' => 'Angga',
                'last_name' => 'Sayogo',
                'email' => 'anggasayogosm@gmail.com',
                'phone' => '08111222333',
            ),
        );

        $data = $this->getMidtransUrl($params);
        return response()->json([
            'snap_url' => $data,
        ],201);
    }


    public function getOrder(Request $request)
    {
        $userid = $request->input('user_id');
    }

}
