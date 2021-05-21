<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Playlist;
use App\Models\Rating;
use App\Models\User;
use App\Models\Video;
use App\Models\Verification;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use APIResponse;
    
    public function index()
    {
        $user = Auth::user();
        
        $orderId = Checkout::where(['status' => 'success', 'user_id' => $user->id])->get()->pluck('id');
        
        $myPlaylist = Playlist::with('category')
        ->addSelect(['rating' => Rating::selectRaw('avg(value) as total')
            ->whereColumn('playlist_id', 'playlists.id')
            ->groupBy('playlist_id')
        ,'user_rated' => Rating::selectRaw('count(value) as total')
            ->whereColumn('playlist_id', 'playlists.id')
            ->groupBy('playlist_id')
        ])
        ->whereIn('playlists.id', $orderId)
        ->paginate(10);
        
        $data = [
            'user' => $user,
            'my_playlist' => $myPlaylist,
        ];
        
        return $this->response("Welcome ".$user->name, $data, 200);
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'mimes:jpeg,jpg,png|max:2048',
            'address' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userAvatar = 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name).'&background=FBBF24&color=ffffff&bold=true&format=png';
        
        if ($request->hasFile('avatar')) {
            $fileName = time().'.'.$request->avatar->extension();
            
            $path = "avatar";
            
            $request->file('avatar')->move(public_path($path), $fileName);
            
            if ($user->avatar !== $userAvatar) unlink(public_path($path . str_replace(env('APP_URL').'/avatar', '', $user->avatar)));
            
            $avatar = env('APP_URL').'/'.$path.'/'.$fileName;
        }
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $avatar ?? $userAvatar,
            'address' => $request->address,
        ]);
        
        return $this->response("Successfully update profile.", null, 201);
    }
    
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $userId = Auth::user()->id;
            
        $user = User::findOrFail($userId);
            
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            return $this->response("The current password is incorrect.", null, 422);
        }
        
        return $this->response("Successfully update password.", null, 201);
    }
}
