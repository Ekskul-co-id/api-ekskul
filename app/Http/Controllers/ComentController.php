<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComentController extends Controller
{
    use APIResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with('user', 'livestream')->get();
        
        return $this->response("Comment found!", $comments, 200);
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
            'user_id' => 'required|integer',
            'livestream_id' => 'required|integer',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'livestream_id' => $request->livestream_id,
            'comment' => $request->comment,
        ]);

        return $this->response("Comment created!", $comment, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $comment = Comment::with('user', 'livestream')->findOrFail($id);
        
        return $this->response("Comment found!", $comment, 200);

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
            'user_id' => 'required|integer',
            'livestream_id' => 'required|integer',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $comment = Comment::findOrFail($id);
        
        $comment->update([
            'user_id' => $request->user_id,
            'livestream_id' => $request->livestream_id,
            'comment' => $request->comment,
        ]);

        return $this->response("Comment updated!", $comment, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        $comment->delete();
        
        return $this->response("Comment deleted!", null, 201);
    }
}
