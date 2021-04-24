<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use App\Traits\APIResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'title' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,jpg,png,svg|max:2048',
            'description' => 'required',
            'video_id' => 'required',
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
            'image' => env('APP_URL').'/'.$path.'/'.$fileName,
            'description' => $request->description,
            'video_id' => $request->video_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        
        return $this->response("Livestream created!", $livestream, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $livestream = Livestream::findOrFail($id);
        
        return $this->response("Livestream found!", $livestream, 200);

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
            'title' => 'required|string|max:255',
            'image' => 'mimes:jpeg,jpg,png,svg|max:2048',
            'description' => 'required',
            'video_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $livestream = Livestream::findOrFail($id);
        
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
            'image' => $image ?? $livestream->image,
            'description' => $request->description,
            'video_id' => $request->video_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
        
        return $this->response("Livestream updated!", $livestream, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $livestream = Livestream::findOrFail($id);
        
        $livestream->delete();
        
        return $this->response("Livestream deleted!", null, 201);
    }
}
