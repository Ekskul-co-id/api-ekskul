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
            'duration' => 'required|integer',
            'video_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $video = Video::create([
            'title' => $request->title,
            'playlist_id' => $request->playlist_id,
            'duration' => $request->duration,
            'video_id' => $request->video_id,
        ]);
        
        return $this->response("Video created!", $video, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $video->load('playlist');
        
        return $this->response("Video found!", $video, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'playlist_id' => 'required|integer',
            'duration' => 'required|integer',
            'video_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $video->update([
            'title' => $request->title,
            'playlist_id' => $request->playlist_id,
            'duration' => $request->duration,
            'video_id' => $request->video_id,
        ]);
        
        return $this->response("Video updated!", $video, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        
        return $this->response("Video deleted", null, 201);
    }
}
