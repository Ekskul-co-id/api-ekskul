<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\User;
use App\Models\Verification;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use APIResponse;
    
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name).'&background=FBBF24&color=ffffff&bold=true&format=png',
                'password' => Hash::make($request->password),
                'device_token' => $request->device_token
            ]);
            
            $user->syncRoles('user');
            
            $code = rand(11111, 99999);
            
            $verify = Verification::create([
                'code' => $code,
                'user_id' => $user->id
            ]);
        
            Mail::to($user->email)->send(new VerificationMail($user, $code));
            
            $token = $user->createToken($user->email)->plainTextToken;

            return $this->response("Successfully registered.", ['user' => $user, 'token' => $token], 201);
        } catch (\Exception $e) {
            return $this->response("Registration failed.", $e, 409);
        }
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->response(null, $validator->errors(), 422);
        }
        
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials)) {
            return $this->response("Unauthorized.", null, 401);
        }

        $user = User::where('email', $request->email)->first();
        
        $user->update([
            'device_token' => $request->device_token ?? $user->device_token
        ]);
        
        $token = $user->createToken($user->email)->plainTextToken;

        return $this->response("Login successfully.", ['user' => $user, 'token' => $token], 201);
    }
    
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->response("Successfully logout.", null, 201, true);
    }
}
