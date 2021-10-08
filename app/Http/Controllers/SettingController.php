<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $settings = Setting::get();

        return $this->response('Settings found!', $settings, 200);
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
            'file' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->file->extension();

        $path = 'settings';

        $request->file->move(public_path($path), $fileName);

        $setting = Setting::create([
            'image_baner' => env('APP_URL').'/'.$fileName,
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $fileName = time().'.'.$request->file->extension();

        $path = 'settings';

        $request->file->move(public_path($path), $fileName);

        $setting->update([
            'image_baner' => env('APP_URL').'/'.$fileName,
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
}
