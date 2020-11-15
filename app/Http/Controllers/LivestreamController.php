<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livestream;

class LivestreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'videod' => 'reqired',
            'start_date' => 'required',
            'title' => 'required',
            'gambar' => 'required',
            'description' => 'required'
        ]);

        $fileName = time().'.'.$request->gambar->extension();
        $path = 'stream';
        $request->gambar->move(public_path($path), $fileName);

        $req = $request->all();
        $data = [
            'videoid' => $req['videoid'],
            'start_date' => $req['start_date'],
            'end_date' => $req['end_date'],
            'title' => $req['title'],
            'gambar' => $path.'/'.$fileName,
            'description' => $req['description']
        ];
        Livestream::create($data);
        return response()->json([
            'status' => true,
            'message' => 'data has created!',
            'data' => $data,
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if($id){
            $live = Livestream::where('id_livestream','=',$id)->first();
            if($live){
                return response()->json([
                    'status' => false,
                    'message' => 'error livestreeam not be found !'
                ],404);
            }
            return response()->json([
                'status' => true,
                'message' => 'details livestreeam be found !',
                'data' => $live,
            ],200);
        }

        return response()->json([
            'status' => true,
            'message' => 'livestreeam be found !',
            'data' => Livestream::get(),
        ],200);

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
        $check = Livestream::where('id_livestream','=',$id)->first();
        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'data not be found!',
            ],404);
        }

        $fileName = time().'.'.$request->gambar->extension();
        $path = 'stream';
        $request->gambar->move(public_path($path), $fileName);

        $req = $request->all();
        $data = [
            'videoid' => $req['videoid'],
            'start_date' => $req['start_date'],
            'end_date' => $req['end_date'],
            'title' => $req['title'],
            'gambar' => $path.'/'.$fileName,
            'description' => $req['description']
        ];
        Livestream::where('id_livestream','=',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'data has updated!',
            'data' => $data,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Livestream::where('id_livestream','=',$id)->delete();
        if(!$data){
            return response()->json([
                'status' => false,
                'message' => 'livestream not be found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'livestream hass delete!'
        ],200);
    }
}
