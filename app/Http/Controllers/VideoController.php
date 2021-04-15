<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::get();
        
        return $this->response("Videos found!", $videos, 200);
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
            'title' => 'required|string|max:100',
            'playlist_id' => 'required|integer',
            'description' => 'required',
            'video_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $video = Video::create([
            'title' => $request->title,
            'playlist_id' => $request->playlist_id,
            'description' => $request->description,
            'video_id' => $request->video_id,
        ]);
        
        return $this->response("Video created!", $video, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = Video::with('playlist')->findOrFail($id);
        
        return $this->response("Video found!", $video, 200);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'playlist_id' => 'required|integer',
            'description' => 'required',
            'video_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $video = Video::findOrFail($id);

        $video->update([
            'title' => $request->title,
            'playlist_id' => $request->playlist_id,
            'description' => $request->description,
            'video_id' => $request->video_id,
        ]);
        
        return $this->response("Video updated!", $video, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        
        $video->delete();
        
        return $this->response("Video deleted", null, 201);
    }
}
