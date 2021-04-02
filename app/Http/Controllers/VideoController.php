<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if ($id) {
            $vid = DB::table('videos')
                ->join('playlists', 'videos.id_playlist', '=', 'playlists.id_playlist')
                ->where('id_video', '=', $id)
                ->first();
            if (!$vid) {
                return response()->json([
                    'status' => false,
                    'message' => 'videos not be found !'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'details video has geted !',
                'data' => $vid,
            ], 200);
        }
        $vid = DB::table('videos')->join('playlists', 'videos.id_playlist', '=', 'playlists.id_playlist')->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'data has geted !',
            'data' => $vid,
        ], 200);
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
            'id_playlist' => 'required',
            'videoid' => 'required',
            'title' => 'required|max:100',
        ]);

        $req = $request->all();
        $data = [
            'id_playlist' => $req['id_playlist'],
            'videoid' => $req['videoid'],
            'title' => $req['title'],
            'description' => $req['description']
        ];
        Video::insert($data);
        return response()->json([
            'status' => true,
            'message' => 'video succesfuly inserted !',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $chcek = Video::Where('id_video', '=', $id)->first();
        if (!$chcek) {
            return response()->json([
                'status' => false,
                'message' => 'video not be found !',
            ], 404);
        }
        $req = $request->all();
        $data = [
            'id_playlist' => $req['id_playlist'],
            'videoid' => $req['videoid'],
            'title' => $req['title'],
            'description' => $req['description']
        ];
        Video::Where('id_video', '=', $id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'video succesfuly update!',
            'data' => $data,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::where('id_video', '=', $id)->delete();
        if (!$video) {
            return response()->json([
                'status' => false,
                'message' => 'video not found !'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Video sucessfuly deleted!'
        ], 201);
    }
}
