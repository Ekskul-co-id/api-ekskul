<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Traits\APIResponse;
use App\Traits\FcmResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    use APIResponse, FcmResponse;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::get();
        
        return $this->response("Announcements found!", $announcements, 200);
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
            'message' => 'required|string',
            'type' => 'required|in:private,public',
            'user_id' => 'required_if:type,private|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $fileName = time().'.'.$request->image->extension();
        
        $path = "announcement";
        
        $request->image->move(public_path($path), $fileName);
        
        $image = env('APP_URL').'/'.$path.'/'.$fileName;
        
        if ($request->type == 'private') {
            $userId = $request->user_id;
            
            $user = User::findOrFail($userId);
            
            $deviceToken = [$user->device_token];
        } else {
            $userId = null;
            
            $deviceToken = User::whereNotNull('device_token')->get()->pluck('device_token')->toArray();
        }
        
        $fcmResponse = $this->fcm($deviceToken, $request->title, $image, $request->message);
        
        $announcement = Announcement::create([
            'title' => $request->title,
            'image' => $image,
            'message' => $request->message,
            'type' => $request->type,
            'user_id' => $userId
        ]);
        
        $data = [
            'announcement' => $announcement,
            'fcm_response' => $fcmResponse
        ];
        
        return $this->response("Announcement created!", $data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        $announcement->load('user');
        
        return $this->response("Announcement found!", $announcement, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        
        return $this->response("Announcement deleted!", null, 201);
    }
}
