<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Playlist;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Playlist::get();
        
        return $this->response("Playlists found!", $playlists, 200);
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
            'name' => 'required|string|max:255',
            'course_id' => 'required|integer'
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $playlist = Playlist::create([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);

        return $this->response("Playlist created!", $playlist, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $playlist = Playlist::with('course', 'video')->findOrFail($id);
        
        return $this->response("Playlist found!", $playlist, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course_id' => 'required|integer'
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $playlist = Playlist::findOrFail($id);
        
        $playlist->update([
            'name' => $request->name,
            'course_id' => $request->course_id
        ]);

        return $this->response("Playlist updated!", $playlist, 201);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playlist = Playlist::findOrFail($id);
        
        $playlist->delete();
        
        return $this->response("Playlist deleted!", null, 201);
    }
}
