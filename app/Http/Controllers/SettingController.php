<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\DeleteBatchRequest;
use App\Http\Requests\Setting\StoreSettingRequest;
use App\Models\Setting;
use App\Traits\APIResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use APIResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::get(['id', 'image_baner', 'active', 'sequence', 'created_at']);

        return $this->response('Settings found!', $settings, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingRequest $request)
    {
        $fileName = time().'.'.$request->file->extension();

        $path = 'settings';

        $request->file->move(public_path($path), $fileName);

        $setting = Setting::create([
            'image_baner' => env('APP_URL').'/'.$fileName,
            'sequence' => $request->sequence,
            'active' => $request->active,
        ]);

        return  $this->response('Setting created!', $setting, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
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
    public function update(Request $request, Setting $setting)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png|max:2048',
            'sequence' => 'required|numeric|unique:settings,sequence,'.$setting->id,
            'active'=> 'required|in:0,1',
        ]);

        $fileName = time().'.'.$request->file->extension();

        $path = 'settings';

        $request->file->move(public_path($path), $fileName);

        $setting->update([
            'image_baner' => env('APP_URL').'/'.$fileName,
            'sequence' => $request->sequence,
            'active' => $request->active,
        ]);

        return  $this->response('Setting updated!', $setting, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return $this->response('Setting deleted!', null, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyBatch(DeleteBatchRequest $request)
    {
        $data = Setting::whereIn('id', $request['id'])->delete();

        return $this->response('Successfully delete setting.', $data, 200);
    }

    public function restore($id)
    {
        $setting = Setting::withTrashed()->findOrFail($id);

        $setting->restore();

        return $this->response('Successfully setting restored!', $setting, 200);
    }

    public function restoreBatch(DeleteBatchRequest $request)
    {
        $data = Setting::withTrashed()->whereIn('id', $request['id'])->restore();

        return $this->response('Successfully setting restored!', $data, 200);
    }
}
