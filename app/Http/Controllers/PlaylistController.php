<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    public function index(Request $request,$id = null)
    {
        if($id){
            $data = DB::table('playlists')
                        ->join('categories','playlists.id_category','=','categories.id_category')
                        ->where('id_playlist','=',$id)
                        ->first();
            if(!$data){
                return response()->json([
                    'status' => false,
                    'message' => 'playlist not found !'
                ],404);
            }
            return response()->json([
                'status' => true,
                'message' => 'details playlist found!',
                'data' => $data,
            ],200);
        }

        $data = DB::table('playlists')
                    ->join('categories','playlists.id_category','=','categories.id_category')
                    ->get();
        return response()->json([
            'status' => true,
            'message' => 'playlist found!',
            'data' => $data,
        ],200);

    }


    public function show(Request $request,$id)
    {
        $data = DB::table('playlists')
                    ->join('categories','playlists.id_category','=','categories.id_category')
                    ->where('categories.id_category','=',$id)
                    ->get();
        if(!$data){
            return response()->json([
                'status' => false,
                'message' => 'playlist based on category not found!'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'playlist based on category found!',
            'data' => $data,
        ],200);
    }


    public function create(Request $request)
    {
        $request->validate([
            'id_category' => 'required',
            'playlist_name' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
            'about_playlist' => 'required',
            'harga' => 'required',
            'rating' => 'required',
            'silabus1' => 'required',
            'silabus2' => 'required',
            'silabus3' => 'required',
            'silabus4' => 'required',
        ]);
        $req = $request->all();

        $fileName = time().'.'.$request->image->extension();
        $path = 'playlist';
        $request->image->move(public_path($path), $fileName);

        $data = [
            'id_category' => $req['id_category'],
            'playlist_name' => $req['playlist_name'],
            'image' => $path.'/'.$fileName,
            'about_playlist' => $req['about_playlist'],
            'harga' => $req['harga'],
            'rating' => $req['rating'],
            'silabus1' => $req['silabus1'],
            'silabus2' => $req['silabus2'],
            'silabus3' => $req['silabus3'],
            'silabus4' => $req['silabus4'],
        ];
        Playlist::create($data);

        return response()->json([
            'status' => true,
            'message' => 'new playlist created !',
            'data' => $data,
        ],201);
    }

    public function update(Request $request,$id)
    {
        $palylist = Playlist::where('id_playlist','=',$id)->first();
        if(!$palylist){
            return response()->json([
                'status' => false,
                'message' => 'playlist not found!'
            ],404);
        }

        $req = $request->all();

        $fileName = time().'.'.$request->image->extension();
        $path = 'playlist';
        $request->image->move(public_path($path), $fileName);

        $data = [
            'id_category' => $req['id_category'],
            'playlist_name' => $req['playlist_name'],
            'image' => $path.'/'.$fileName,
            'about_playlist' => $req['about_playlist'],
            'harga' => $req['harga'],
            'rating' => $req['rating'],
            'silabus1' => $req['silabus1'],
            'silabus2' => $req['silabus2'],
            'silabus3' => $req['silabus3'],
            'silabus4' => $req['silabus4'],
        ];
        Playlist::where('id_playlist','=',$id)->update($data);

        return response()->json([
            'status' => true,
            'message' => 'playlist updated!',
            'data' => $data,
        ],201);
    }


    public function destroy(Request $request,$id)
    {
        $data = Playlist::where('id_playlist','=',$id)->delete();
        if(!$data){
            return response()->json([
                'status' => false,
                'message' => 'playlist not be found !'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'playlist hass delete!'
        ],200);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $search = Playlist::where('playlist_name','like','%'.$keyword.'%')->get();
        if(!$search){
            return response()->json([
                'status' => false,
                'message' => 'course not be found',
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'course be found',
            'data' => $search,
        ],200);

    }

}
