<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    use APIResponse;
    
    private function getMidtransUrl($params)
    {
        // Set your Merchant Server Key
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = (bool) env('IS_PRODUCTION');
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
        
        $checkouts = Checkout::with('course')->where('user_id', $userId)->get();
                        
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
                    'status' => 'pending',
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
        
        $order = Checkout::with('user', 'course')->findOrFail($createOrder->id);
        
        $itemDetails = [
            [
                'id' => $order->course->id,
                'price' => $order->course->price,
                'quantity' => 1,
                'name' => $order->course->name,
                'category' => $order->course->category->name,
                'brand' => 'Ekskul.co.id'
            ]
        ];
        
        $params = [
            'transaction_details' => [
                'order_id' => $order->id.'-'.Str::random(5),
                'gross_amount' => $order->course->price,
            ],
            'item_details' => $itemDetails, 
            'customer_details' => [
                'name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        $snapUrl = $this->getMidtransUrl($params);
        
        $order->update([
            'snap_url' => $snapUrl,
            'metadata' => [
                'course_id' => $order->course_id,
                'price' => $order->course->price,
                'course_name' => $order->course->name,
            ]
        ]);
        
        return $this->response("Order Created.", ['order' => $order, 'snap_url' => $snapUrl], 201);
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
