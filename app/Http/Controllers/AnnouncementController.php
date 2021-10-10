<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\DeleteBatchRequest;
use App\Http\Requests\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Responses\PaginationResponse;
use App\Http\Responses\SimpleResponse;
use App\Models\Announcement;
use App\Models\User;
use App\Traits\APIResponse;
use App\Traits\FcmResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use APIResponse, FcmResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterRequest $request)
    {
        // filter data
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);
        $order_by = $request->input('order_by') ? $request->input('order_by') : 'created_at';
        $order_direction = $request->input('order_direction') ? strtoupper($request->input('order_direction')) : 'ASC';

        $query = Announcement::query();

        // clone query
        $result = (clone $query)->filter($request->all())->limit($limit)->offset($offset)->orderBy($order_by, $order_direction)
            ->select('id', 'title', 'image', 'message', 'type', 'user_id', 'created_at', )->get();

        $totalResult = (clone $query)->filter($request->all())->count();
        $totalData = (clone $query)->count();

        // return data with pagination
        return new PaginationResponse($result, $totalResult, $totalData, $offset, $limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $fileName = time().'.'.$request->image->extension();

        $path = 'announcement';

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
            'user_id' => $userId,
        ]);

        $data = [
            'announcement' => $announcement,
            'fcm_response' => $fcmResponse,
        ];

        return $this->response('Announcement created!', $data, 201);
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

        return $this->response('Announcement found!', $announcement, 200);
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

        return $this->response('Announcement deleted!', null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyBatch(DeleteBatchRequest $request)
    {
        $data = Announcement::whereIn('id', $request['id'])->delete();

        return $this->response('Announcement deleted!', $data, 200);
    }

    public function restore($id)
    {
        $announcement = Announcement::withTrashed()->findOrFail($id);

        $announcement->restore();

        return $this->response('Announcement restored!', $announcement, 200);

    }

    public function restoreBatch(DeleteBatchRequest $request)
    {
        $data = Announcement::withTrashed()->whereIn('id', $request['id'])->restore();

        return $this->response('Announcement restored!', $data, 200);

    }
}
