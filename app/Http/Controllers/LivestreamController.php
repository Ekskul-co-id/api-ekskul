<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LivestreamController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livestreams = Livestream::get();
        
        return $this->response("Livestreams found!", $livestreams, 200);
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
            'title' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,jpg,png,svg|max:2048',
            'youtube_id' => 'required',
            'description' => 'required',
            'user_id' => 'required|integer',
            'price' => 'required',
            'silabus' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $fileName = time().'.'.$request->image->extension();
        
        $path = "stream";
        
        $request->image->move(public_path($path), $fileName);
        
        $start_date = date('Y/m/d H:i', strtotime($request->start_date));
        
        $end_date = date('Y/m/d H:i', strtotime($request->end_date));
        
        $livestream = Livestream::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image' => env('APP_URL').'/'.$path.'/'.$fileName,
            'youtube_id' => $request->youtube_id,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'silabus' => $request->silabus,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        
        return $this->response("Livestream created!", $livestream, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Livestream  $livestream
     * @return \Illuminate\Http\Response
     */
    public function show(Livestream $livestream)
    {
        $livestream->load('user');
        
        return $this->response("Livestream found!", $livestream, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livestream  $livestream
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Livestream $livestream)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'mimes:jpeg,jpg,png,svg|max:2048',
            'youtube_id' => 'required',
            'description' => 'required',
            'user_id' => 'required|integer',
            'price' => 'required',
            'silabus' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        if($request->hasFile('image')){
            $fileName = time().'.'.$request->image->extension();
            
            $path = "stream";
            
            $request->image->move(public_path($path), $fileName);
            
            unlink(public_path($path . $livestream->image));
            
            $image = env('APP_URL').'/'.$path.'/'.$fileName;
        }
        
        $start_date = date('Y/m/d H:i', strtotime($request->start_date));
        
        $end_date = date('Y/m/d H:i', strtotime($request->end_date));
        
        $livestream->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image' => $image ?? $livestream->image,
            'youtube_id' => $request->youtube_id,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'silabus' => $request->silabus,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        
        return $this->response("Livestream updated!", $livestream, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Livestream  $livestream
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livestream $livestream)
    {
        $livestream->delete();
        
        return $this->response("Livestream deleted!", null, 201);
    }
}
