<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Playlist;
use App\Models\Rating;
use App\Models\User;
use App\Models\Verification;
use App\Models\Video;
use App\Rules\CurrentPassword;
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

        return $this->response('Welcome '.$user->name, $user, 200);
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

        if (!$user->has_update_avatar) {
            $avatar = $userAvatar;
        }

        if ($request->hasFile('avatar')) {
            $fileName = time().'.'.$request->avatar->extension();

            $path = 'avatar';

            $request->file('avatar')->move(public_path($path), $fileName);

            if ($user->avatar !== $userAvatar) {
                unlink(public_path($path.str_replace(env('APP_URL').'/avatar', '', $user->avatar)));
            }

            $avatar = env('APP_URL').'/'.$path.'/'.$fileName;

            $hasUpdateAvatar = true;
        } else {
            $hasUpdateAvatar = $user->has_update_avatar;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $avatar ?? $user->avatar,
            'address' => $request->address,
            'has_update_avatar' => $hasUpdateAvatar,
        ]);

        return $this->response('Successfully update profile.', $user, 201);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|password',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }

        $userId = Auth::user()->id;

        $user = User::findOrFail($userId);

        return $this->response('Successfully update password.', null, 201);
    }
}
