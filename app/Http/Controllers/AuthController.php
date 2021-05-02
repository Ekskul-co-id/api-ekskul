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
    
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register",
     *     description="Register with name, email, password",
     *     operationId="authRegister",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass register credentials",
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", format="text", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="EkSkuLPassword"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="EkSkuLPassword"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     * )
     */
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
                'avatar' => 'https://ui-avatars.com/api/?name='.str_replace(' ', '+', $request->name).'&background=FBBF24&color=ffffff&bold=true&format=svg',
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
    
   /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     description="Login with email, password",
     *     operationId="authLogin",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass register credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="EkSkuLPassword"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     * )
     */
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
            'device_token' => $request->device_token
        ]);
        
        $token = $user->createToken($user->email)->plainTextToken;

        return $this->response("Login successfully.", ['user' => $user, 'token' => $token], 201);
    }
    
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout",
     *     description="Logout",
     *     operationId="authLogout",
     *     security={{ "bearer_token": {} }},
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *     ),
     * )
     */
    public function logout()
    {
        Auth::user()->tokens()->delete();

        return $this->response("Successfully logout.", null, 201, true);
    }
}
