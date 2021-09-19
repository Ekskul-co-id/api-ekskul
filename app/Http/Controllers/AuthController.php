<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\SocialProvider;
use App\Models\User;
use App\Models\Verification;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use APIResponse;
    
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['github', 'facebook', 'google'])) {
            return $this->response("Please using github, facebook or google.", null, 422);
        }
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
    
    public function redirectToProvider(Request $request, $provider)
    {
        $validated = $this->validateProvider($provider);
        
        if (!is_null($validated)) {
            return $validated;
        }
        
        $deviceToken = $request->get('device_token');
        
        return Socialite::driver($provider)->with(['state' => $deviceToken])->stateless()->redirect();
    }
    
    public function handleProviderCallback(Request $request, $provider)
    {
        $validated = $this->validateProvider($provider);
        
        if (!is_null($validated)) {
            return $validated;
        }
        
        try {
            $userSocial = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $e) {
            return $this->response("Invalid credentials provider.", null, 422);
        }
        
        $deviceToken = $request->input('state');
        
        $hasRegistered = User::where('email', $userSocial->getEmail())->first();
        
        $hasProvider = SocialProvider::where(['provider' => $provider, 'provider_id' => $userSocial->getId()])
            ->first();
            
        if ($hasProvider) {
            $user = $hasRegistered;
            
            $msg = "Successfully logged in";
            
            $user->update([
                'device_token' => $deviceToken ?? $user->device_token,
            ]);
        } else {
            if ($hasRegistered) {
                return $this->response("Email has been used, please try another method.", null, 422);
            }
            
            $user = User::create([
                'email' => $userSocial->getEmail(),
                'name' => $userSocial->getName(),
                'avatar' => $userSocial->getAvatar(),
                'device_token' => $deviceToken,
            ]);
            
            $user->markEmailAsVerified();
            
            $msg = "Registration successful!";
        }
        
        $user->providers()->updateOrCreate([
            'provider' => $provider,
            'provider_id' => $userSocial->getId(),
        ],
        [
            'user_id' => $user->id,
        ]);
        
        $token = $user->createToken($user->email)->plainTextToken;
        
        return $this->response($msg, ['user' => $user, 'token' => $token, 'social' => $userSocial], 201);
    }
    
    public function handleOauth(Request $request)
    {
        $result = json_decode($request->getContent(), true);
        
        $data = $result['providerData'][0];
        
        $deviceToken = $result['device_token'];
        
        $hasRegistered = User::where('email', $data['email'])->first();
        
        $hasProvider = SocialProvider::where(['provider' => $data['providerId'], 'provider_id' => $data['uid']])
            ->first();
            
        if ($hasProvider) {
            $user = $hasRegistered;
            
            $msg = "Successfully logged in";
            
            $user->update([
                'device_token' => $deviceToken ?? $user->device_token,
            ]);
        } else {
            if ($hasRegistered) {
                return $this->response("Email has been used, please try another method.", null, 422);
            }
            
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['displayName'],
                'avatar' => $data['photoURL'],
                'device_token' => $deviceToken,
            ]);
            
            $user->markEmailAsVerified();
            
            $msg = "Registration successful!";
        }
        
        $user->providers()->updateOrCreate([
            'provider' => $data['providerId'],
            'provider_id' => $data['uid'],
        ],
        [
            'user_id' => $user->id,
        ]);
        
        $token = $user->createToken($user->email)->plainTextToken;
        
        return $this->response($msg, ['user' => $user, 'token' => $token, 'social' => $result], 201);
    }
    
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->response("Successfully logout.", null, 201, true);
    }
}
