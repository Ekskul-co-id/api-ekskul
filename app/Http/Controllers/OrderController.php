<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Playlist;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $checkouts = Checkout::with('user', 'playlist')->get();
                        
        return $this->response("Transaction found!", $checkouts, 200);
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
            'user_id' => 'required|integer',
            'playlist_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $check = Checkout::with('user', 'playlist')
                ->where([
                    'user_id' => $request->user_id,
                    'playlist_id' => $request->playlist_id,
                    'status' => 'pending',
                ])
                ->first();
        
        if($check){
            return $this->response("Order has been created.", $check, 201);
        }

        $createOrder = Checkout::create([
            'user_id' => $request->user_id,
            'playlist_id' => $request->playlist_id,
            'qty' => 1,
        ]);
        
        $order = Checkout::with('user', 'playlist')->findOrFail($createOrder->id);
        
        $itemDetails = [
            [
                'id' => $order->playlist->id,
                'price' => $order->playlist->price,
                'quantity' => 1,
                'name' => $order->playlist->name,
                'category' => $order->playlist->category->name,
                'brand' => 'Ekskul.co.id'
            ]
        ];
        
        $params = [
            'transaction_details' => [
                'order_id' => $order->id.'-'.Str::random(5),
                'gross_amount' => $order->playlist->price,
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
                'playlist_id' => $order->playlist_id,
                'price' => $order->playlist->price,
                'playlist_name' => $order->playlist->name,
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
        $checkout = Checkout::with('user', 'playlist')
                        ->where(['id' => $id, 'status' => 'success'])
                        ->firstOrFail();
        
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
