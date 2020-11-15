<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $req = $request->all();
        $order = Checkout::create([
            'id_user' => $req['id_user'],
            'id_playlist' => $req['id_playlist'],
            'qty' => 1,
        ]);

        $detailsdata = DB::table('checkouts')
                        ->join('users','checkouts.id_user','=','users.id')
                        ->join('playlists','checkouts.id_playlist','=','playlists.id_playlist')
                        ->join('categories','playlists.id_category','=','categories.id_category')
                        ->where('id_checkout','=',$order->id)
                        ->first();
        
        $itemDetails = [
            [
                'id' => $detailsdata->id_playlist,
                'price' => $detailsdata->harga,
                'quantity' => 1,
                'name' => $detailsdata->playlist_name,
                'category' => $detailsdata->category_name,
                'brand' => 'Ekskul.co.id'
            ]
        ];
        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id.'-'.Str::random(5),
                'gross_amount' => $detailsdata->harga,
            ),
            'item_details' => $itemDetails, 
            'customer_details' => array(
                'first_name' => $detailsdata->name,
                'email' => $detailsdata->email,
            ),
        );

        $data = $this->getMidtransUrl($params);

        Checkout::where('id_checkout','=',$order->id)->update(['snap_url' => $data]);
        Checkout::where('id_checkout','=',$order->id)->update([
            'metadata' => [
                'id_playlist' => $detailsdata->id_playlist,
                'harga' => $detailsdata->harga,
                'playlist_name' => $detailsdata->playlist_name,
            ]
        ]);


        return response()->json([
            'status' => true,
            'message' => 'order Created',
            'data' => $detailsdata,
            'snap_url' => $data,
        ],201);
    }

    public function index(Request $request,$id = null)
    {
        if($id){
            $detailsdata = DB::table('checkouts')
                        ->join('users','checkouts.id_user','=','users.id')
                        ->join('playlists','checkouts.id_playlist','=','playlists.id_playlist')
                        ->join('categories','playlists.id_category','=','categories.id_category')
                        ->where('id_checkout','=',$id)
                        ->first();
            if(!$detailsdata){
                return response()->json([
                    'status' => false,
                    'message' => 'id transaction not be found !',
                ],404);
            }
            return response()->json([
                'status' => true,
                'message' => 'details transaction found !',
                'data' => $detailsdata,
            ],200);
            
        }

        $detailsdata = DB::table('checkouts')
                        ->join('users','checkouts.id_user','=','users.id')
                        ->join('playlists','checkouts.id_playlist','=','playlists.id_playlist')
                        ->join('categories','playlists.id_category','=','categories.id_category')
                        ->get();
        return response()->json([
            'status' => true,
            'message' => 'details transaction found !',
            'data' => $detailsdata,
        ],200);
    }


    public function getOrder(Request $request)
    {
        $userid = $request->input('user_id');
    }

}
