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
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'rating' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'silabus1' => 'required',
            'silabus2' => 'required',
            'silabus3' => 'required',
            'silabus4' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->image->extension();
        
        $path = "playlist";
        
        $request->image->move(public_path($path), $fileName);

        $playlist = Playlist::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'about' => $request->about,
            'price' => $request->price,
            'rating' => $request->rating,
            'image' => $path.'/'.$fileName,
            'silabus1' => $request->silabus1,
            'silabus2' => $request->silabus2,
            'silabus3' => $request->silabus3,
            'silabus4' => $request->silabus4,
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
        $playlist = Playlist::with('category', 'video')->findOrFail($id);
        
        return $this->response("Playlist found!", $playlist, 200);
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
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'about' => 'required',
            'price' => 'required',
            'rating' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'silabus1' => 'required',
            'silabus2' => 'required',
            'silabus3' => 'required',
            'silabus4' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $playlist = Playlist::findOrFail($id);
        
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            
            $path = "playlist";
            
            $request->image->move(public_path($path), $fileName);
            
            $image = $path.'/'.$fileName;
        }
        $playlist->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'about' => $request->about,
            'price' => $request->price,
            'rating' => $request->rating,
            'image' => $image ?? $playlist->image,
            'silabus1' => $request->silabus1,
            'silabus2' => $request->silabus2,
            'silabus3' => $request->silabus3,
            'silabus4' => $request->silabus4,
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
