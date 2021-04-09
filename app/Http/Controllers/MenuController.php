<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Playlist;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $category = Category::with(['playlist' => function ($q) {
            $q->paginate(10);
        }])->where('slug', $slug)->firstOrFail();
        
        return $this->response("Category found!", $category, 200);
    }
    
    public function listPlaylist(Request $request)
    {
        $userId = Auth::user()->id;
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $userId])->get()->pluck('id');
        
        $value = e($request->get('q'));
        
        if(!empty($value)) {
            $playlists = Playlist::with('category', 'video')->whereNotIn('playlists.id', $orderId)->where('name', 'LIKE', '%'.$value.'%')->paginate(10);
        }else{
            $playlists = Playlist::with('category', 'video')->whereNotIn('playlists.id', $orderId)->paginate(10);
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
}
