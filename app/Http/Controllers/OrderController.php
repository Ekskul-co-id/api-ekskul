<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\PaymentLog;
use App\Traits\APIResponse;
use App\Traits\FcmResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    use APIResponse, FcmResponse;
    
    private function getMidtransUrl($params)
    {
        // Set your Merchant Server Key
        Config::$serverKey = env('MIDTRANS_SERVER_KEY_PROD');
        Config::$isProduction = (bool) env('IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = (bool) env('IS_3DS');

        $snapUrl = Snap::createTransaction($params)->redirect_url;
        
        return $snapUrl;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        
        $checkouts = Checkout::with('course', 'payment_log')->where('user_id', $userId)->get();
                        
        return $this->response("Details transaction found!", $checkouts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $check = Checkout::with('user', 'course')
                ->where([
                    'user_id' => $userId,
                    'course_id' => $request->course_id,
                ])
                ->first();
        
        if($check){
            return $this->response("Order has been created.", $check, 201);
        }

        $createOrder = Checkout::create([
            'user_id' => $userId,
            'course_id' => $request->course_id,
            'qty' => 1,
        ]);
        
        $order = Checkout::with('user', 'course')->find($createOrder->id);
        
        if (($order->course->is_paid) && ($order->course->price !== 0)) {
            $itemDetails = [
               [
                    'id' => $order->course->id,
                    'price' => $order->course->price,
                    'quantity' => 1,
                    'name' => $order->course->name,
                    'brand' => 'Ekskul.co.id',
                    'category' => $order->course->category->name,
                    'merchant_name' => 'Ekskul.co.id'
                ]
            ];
        
            $params = [
                'transaction_details' => [
                    'order_id' => $order->id.'-'.Str::random(5),
                    'gross_amount' => $order->course->price,
                ],
                'item_details' => $itemDetails, 
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                ],
                'enabled_payments' => [
                    'credit_card', 'cimb_clicks', 'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va', 'bca_va', 'bni_va', 'bri_va', 'other_va', 'gopay', 'indomaret', 'danamon_online', 'akulaku', 'shopeepay'
                ],
            ];

            $snapUrl = $this->getMidtransUrl($params);
            
            $status = 'pending';
        } else {
            $fcmResponse = $this->fcm([$order->user->device_token], "Transaksi berhasil!", $order->course->image, "Berhasil membeli course ".$order->course->name.".");
            
            PaymentLog::create([
                'status' => $status,
                'checkout_id' => $order->id,
                'payment_type' => 'subscribe',
                'raw_response' => json_encode($order->course),
                'fcm_response' => json_encode($fcmResponse)
            ]);
        }
        
        $order->update([
            'snap_url' => $snapUrl ?? '',
            'status' => $status,
            'metadata' => [
                'course_id' => $order->course_id,
                'price' => $order->course->price,
                'course_name' => $order->course->name,
            ]
        ]);
        
        return $this->response("Order Created.", ['order' => $order, 'snap_url' => $snapUrl ?? ''], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkout = Checkout::with('course')->findOrFail($id);
        
        return $this->response("Details transaction found!", $checkout, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
