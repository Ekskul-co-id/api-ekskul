<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::get();
        
        return $this->response("Ratings found!", $ratings, 200);
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
            'playlist_id' => 'required|integer',
            'user_id' => 'required|integer|unique:ratings',
            'value' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $rating = Rating::create([
            'playlist_id' => $request->playlist_id,
            'user_id' => $request->user_id,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rating = Rating::finfOrFail($id);
        
        return $this->response("Rating found!", $rating, 200);
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
        $rating = Rating::finfOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'playlist_id' => 'required|integer',
            'user_id' => 'required|integer|unique:ratings,user_id,'.$rating->user->id,
            'value' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $rating->update([
            'playlist_id' => $request->playlist_id,
            'user_id' => $request->user_id,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating updated!", $rating, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rating = Rating::finfOrFail($id);
        
        $rating->delete();
        
        return $this->response("Rating deleted!", null, 201);
    }
}