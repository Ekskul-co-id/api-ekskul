<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Playlist;
use App\Models\Rating;
use App\Models\Video;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    use APIResponse;
    
    public function listCategory()
    {
        $categories = Category::get();
        
        return $this->response("Categories found!", $categories, 200);
    }
    
    public function detailCategory($slug)
    {
        $userId = Auth::user()->id;
        
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()->pluck('id');
        
        $playlists = Playlist::with('category')
        ->addSelect(['rating' => Rating::selectRaw('avg(value) as total')
            ->whereColumn('playlist_id', 'playlists.id')
            ->groupBy('playlist_id')
        ,'user_rated' => Rating::selectRaw('count(value) as total')
            ->whereColumn('playlist_id', 'playlists.id')
            ->groupBy('playlist_id')
        ])
        ->whereNotIn('playlists.id', $orderId)
        ->where('category_id', $category->id)
        ->get();
        
        return $this->response("Category found!", $playlists, 200);
    }
    
    public function listPlaylist(Request $request)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()->pluck('id');
        
        $value = e($request->get('q'));
        
        if(!empty($value)) {
            $playlists = Playlist::with('category')
            ->addSelect(['rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('playlist_id', 'playlists.id')
                ->groupBy('playlist_id')
            ,'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('playlist_id', 'playlists.id')
                ->groupBy('playlist_id')
            ,'total_videos' => Video::selectRaw('count(id) as total')
                ->whereColumn('playlist_id', 'playlists.id')
                ->groupBy('playlist_id')
            ])
            ->whereNotIn('playlists.id', $orderId)->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        }else{
            $playlists = Playlist::with('category')
            ->addSelect(['rating' => Rating::selectRaw('avg(value) as total')
                ->whereColumn('playlist_id', 'playlists.id')
                ->groupBy('playlist_id')
            ,'user_rated' => Rating::selectRaw('count(value) as total')
                ->whereColumn('playlist_id', 'playlists.id')
                ->groupBy('playlist_id')
            ])
            ->whereNotIn('playlists.id', $orderId)->paginate(10);
        }
        
        $data = [
            'playlists' => $playlists,
            'search' => $value,
        ];
        
        return $this->response("Playlists found!", $data, 200);
    }
    
    public function detailPlaylist($slug)
    {
        $playlist = Playlist::with('category', 'video')->where('slug', $slug)->firstOrFail();
        
        return $this->response("Playlist found!", $playlist, 200);
    }
    
    public function storeRating(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $playlistId = Playlist::where('slug', $slug)->pluck('id')->implode(' ');
        
        $rating = Rating::create([
            'playlist_id' => $playlistId,
            'user_id' => $userId,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
    
    public function upateRating(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
        
        $playlistId = Playlist::where('slug', $slug)->pluck('id')->implode(' ');
        
        $rating = Rating::where(['playlist_id' => $playlistId, 'user_id' => $userId])->firstOrFail();
        
        $rating->update([
            'playlist_id' => $playlistId,
            'user_id' => $userId,
            'value' => $request->value,
        ]);
        
        return $this->response("Rating created!", $rating, 201);
    }
}
