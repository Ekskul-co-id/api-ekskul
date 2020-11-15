<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentar;
use Illuminate\Support\Facades\DB;

class ComentController extends Controller
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
            'id_user' => 'required',
            'id_livestream' => 'required',
            'comentar' => 'required',
        ]);
        $coment = Comentar::create([
            'id_user' => $request->id_user,
            'id_livestream' => $request->id_livestream,
            'comentar' => $request->comentar,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'data has created !',
            'data' => $coment,
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

            $live = DB::table('comentars')
            ->join('users','comentars.id_user','=','users.id')
            ->join('livestreams','comentars.id_livestream','=','livestreams.id_livestream')
            ->where('id_comentar','=',$id)
            ->first();

            if(!$live){
                return response()->json([
                    'status' => false,
                    'message' => 'error Comentars not be found !'
                ],404);
            }
            return response()->json([
                'status' => true,
                'message' => 'details Comentars be found !',
                'data' => $live,
            ],200);
        }
        $coment = DB::table('comentars')
                    ->join('users','comentars.id_user','=','users.id')
                    ->join('livestreams','comentars.id_livestream','=','livestreams.id_livestream')
                    ->get();

        return response()->json([
            'status' => true,
            'message' => 'Comentars be found !',
            'data' => $coment,
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
        $check = Comentar::where('id_comentar','=',$id)->first();
        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'Comentars not be found !'
            ],404);
        }

        $coment = Comentar::Where('id_comentar','=',$id)->update([
            'id_user' => $request->id_user,
            'id_livestream' => $request->id_livestream,
            'comentar' => $request->comentar,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'data has updated !',
            'data' => $coment,
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
        $data = Comentar::where('id_Comentar','=',$id)->delete();
        if(!$data){
            return response()->json([
                'status' => false,
                'message' => 'Comentar not be found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Comentar hass delete!'
        ],200);
    }
}
