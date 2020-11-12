<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if($id){
            $seting = Settings::where('id_setting','=',$id)->first();
            if(!$seting){
                return response()->json([
                    'status' => false,
                    'message' => 'setings not found !'
                ],404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Details setings has Get !',
                'data' => $seting,
            ]);

        }
        $seting = Settings::get();
        return response()->json([
            'status' => true,
            'message' => 'Data setings has Get !',
            'data' => $seting,
        ]);
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
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);
  
        $fileName = time().'.'.$request->file->extension();
        $path = 'settings';
        $request->file->move(public_path($path), $fileName);
        Settings::insert(['image_baner' => $fileName]);

        return  response()->json([
            'status' => true,
            'message' => 'data sucessfuly stored!',
            'image' => $path.'/'.$fileName,
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $seting = Settings::where('id_setting','=',$id)->first();

        if(!$seting){
            return response()->json([
                'status' => false,
                'message' => 'setings not found !'
            ],404);
        }
        
        $fileName = time().'.'.$request->file->extension();
        $path = 'settings';
        $request->file->move(public_path($path), $fileName);
        Settings::where('id_setting','=',$id)->update(['image_baner' => $fileName]);

        return  response()->json([
            'status' => true,
            'message' => 'data sucessfuly updated!',
            'image' => $path.'/'.$fileName,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Settings::where('id_setting','=',$id)->delete();
        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Settings Baner not found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Settings Baner sucessfuly deleted!'
        ],404);
    }
}
