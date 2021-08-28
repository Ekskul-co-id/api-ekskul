<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\PaymentLog;
use App\Traits\APIResponse;
use App\Traits\FcmResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        Config::$serverKey = env('IS_PRODUCTION') ? env('MIDTRANS_SERVER_KEY_PROD') : env('MIDTRANS_SERVER_KEY_DEV');
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
        
        $checkouts = Checkout::with('course', 'livestream', 'paymentLog')->where('user_id', $userId)->get();
                        
        return $this->response("Details transaction found!", $checkouts, 200);
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
            'item_id' => 'required|integer',
            'type' => 'required|in:course,livestream',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $type = $request->type;
        
        $checkout = Checkout::with('user', 'course');
        
        if ($type == 'course') {
             $checkout->where([
                'user_id' => $userId,
                'course_id' => $request->item_id,
                'type' => $type,
                'status' => 'pending'
            ]);
        } elseif ($type == 'livestream') {
           $checkout->where([
                'user_id' => $userId,
                'livestream_id' => $request->item_id,
                'type' => $type,
                'status' => 'pending'
            ]);
        }
        
        $check = $checkout->first();
        
        if($check){
            return $this->response("Order has been created.", $check, 201);
        }
        
        DB::beginTransaction();
        
        try {
            if ($type == 'course') {
                $createOrder = Checkout::create([
                    'user_id' => $userId,
                    'course_id' => $request->item_id,
                    'type' => $type,
                    'qty' => 1,
                ]);
            } elseif ($type == 'livestream') {
                $createOrder = Checkout::create([
                    'user_id' => $userId,
                    'livestream_id' => $request->item_id,
                    'type' => $type,
                    'qty' => 1,
                ]);
            }
            
            $order = Checkout::with('user', 'course')->find($createOrder->id);
            
            $orderId = Str::orderedUuid();
            
            if (($order->type == 'course') && ($order->course->is_paid) && ($order->course->price !== 0)) {
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
                        'order_id' => $orderId,
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
            } elseif (($order->type == 'livestream') && ($order->livestream->is_paid) && ($order->livestream->price !== 0)) {
                $itemDetails = [
                   [
                        'id' => $order->livestream->id,
                        'price' => $order->livestream->price,
                        'quantity' => 1,
                        'name' => $order->livestream->title,
                        'brand' => 'Ekskul.co.id',
                        'category' => $order->livestream->category->name,
                        'merchant_name' => 'Ekskul.co.id'
                    ]
                ];
            
                $params = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => $order->livestream->price,
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
                $status = 'success';
            }
            
            if ($order->type == 'course') {
                $metadata = [
                    'course_id' => $order->course_id,
                    'price' => $order->course->price,
                    'name' => $order->course->name,
                ];
                
                $fcmResponse = $this->fcm([$order->user->device_token], "Transaksi berhasil!", $order->course->image, "Berhasil membeli course ".$order->course->name.".");
            } elseif ($order->type == 'livestream') {
                $metadata = [
                    'livestream_id' => $order->livestream_id,
                    'price' => $order->livestream->price,
                    'name' => $order->livestream->title,
                ];
                
                $fcmResponse = $this->fcm([$order->user->device_token], "Transaksi berhasil!", $order->livestream->image, "Berhasil memesan livestream ".$order->livestream->title.".");
            }
            
            if ($status == 'success') {
                PaymentLog::create([
                    'status' => $status,
                    'checkout_id' => $order->id,
                    'payment_type' => 'subscribe',
                    'raw_response' => $order->course,
                    'fcm_response' => $fcmResponse
                ]);
            }
            
            $order->update([
                'snap_url' => $snapUrl ?? '',
                'status' => $status,
                'metadata' => $metadata,
                'order_id' => $orderId
            ]);
            
            DB::commit();
            
            return $this->response("Order Created.", ['order' => $order, 'snap_url' => $snapUrl ?? ''], 201);
        } catch (Exception $e) {
            DB::rollBack();
            
            return $this->response("Create order failed.", $e, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        $checkout->load('course', 'livestream', 'paymentLog');
        
        return $this->response("Details transaction found!", $checkout, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}
